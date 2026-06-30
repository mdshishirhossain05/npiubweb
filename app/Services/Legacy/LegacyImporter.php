<?php

namespace App\Services\Legacy;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

/**
 * Repeatable, idempotent importer of legacy CMS data into the new schema.
 *
 * The legacy database is treated as strictly read-only: rows are pulled from a
 * separate `legacy` connection and upserted into the new tables keyed on a
 * stable `legacy_id`, so re-running the import updates rather than duplicates.
 *
 * Behaviour is driven entirely by the declarative `config/legacy.php` map —
 * no closures, so the config stays `config:cache`-safe for production. Each
 * entry describes one legacy table, the target Eloquent model, and the
 * legacy-column => new-attribute mapping.
 */
class LegacyImporter
{
    /**
     * @param  array<int, array<string, mixed>>  $imports
     */
    public function __construct(
        private readonly DatabaseManager $db,
        private readonly string $connection,
        private readonly array $imports,
    ) {}

    /**
     * Run every configured import.
     *
     * @param  callable(string $model, int $count): void|null  $onImported
     *                                                                      Optional per-model progress callback.
     * @return array<class-string<Model>, int> imported row counts, keyed by model
     */
    public function run(?callable $onImported = null): array
    {
        $results = [];

        // Bulk import would otherwise flood the audit log with one entry per
        // row; disable activity logging for the duration of the run.
        $previous = Config::get('activitylog.enabled', true);
        Config::set('activitylog.enabled', false);

        try {
            foreach ($this->imports as $map) {
                $model = (string) ($map['model'] ?? '');

                // is_subclass_of narrows $model to class-string<Model>; an empty
                // or non-model value simply yields false and is skipped.
                if (! is_subclass_of($model, Model::class)) {
                    continue;
                }

                $count = $this->importTable($model, (array) $map);
                $results[$model] = $count;

                if ($onImported !== null) {
                    $onImported($model, $count);
                }
            }
        } finally {
            Config::set('activitylog.enabled', $previous);
        }

        return $results;
    }

    /**
     * @param  class-string<Model>  $model
     * @param  array<string, mixed>  $map
     */
    private function importTable(string $model, array $map): int
    {
        $table = (string) ($map['table'] ?? '');
        $key = (string) ($map['key'] ?? 'id');

        /** @var array<string, string> $columns legacy column => new attribute */
        $columns = (array) ($map['columns'] ?? []);
        /** @var list<string> $dates new attributes that should be parsed as dates */
        $dates = array_values((array) ($map['dates'] ?? []));
        /** @var array<string, mixed> $defaults always-applied attribute defaults */
        $defaults = (array) ($map['defaults'] ?? []);

        $connection = $this->db->connection($this->connection);
        $schema = $connection->getSchemaBuilder();

        // A legacy table that does not exist is skipped rather than fatal — the
        // same config can then describe more tables than any one dump contains.
        if ($table === '' || ! $schema->hasTable($table)) {
            return 0;
        }

        // Only map columns that are actually present in this legacy dump.
        $present = $schema->getColumnListing($table);
        $columns = array_filter(
            $columns,
            static fn (string $legacyColumn): bool => in_array($legacyColumn, $present, true),
            ARRAY_FILTER_USE_KEY,
        );

        $count = 0;

        $connection->table($table)
            ->orderBy($key)
            ->chunkById(500, function ($rows) use ($model, $columns, $dates, $defaults, $key, &$count): void {
                foreach ($rows as $row) {
                    $attributes = $defaults;

                    foreach ($columns as $legacyColumn => $newAttribute) {
                        $value = data_get($row, $legacyColumn);

                        if (in_array($newAttribute, $dates, true)) {
                            $value = $this->toDate($value);
                        }

                        // A null legacy value means "no data" — never clobber a
                        // generated value (e.g. a slug) or violate NOT NULL on
                        // re-import. The model/DB default stands instead.
                        if ($value === null) {
                            continue;
                        }

                        $attributes[$newAttribute] = $value;
                    }

                    $legacyId = data_get($row, $key);

                    $model::query()->updateOrCreate(
                        ['legacy_id' => $legacyId],
                        $attributes,
                    );

                    $count++;
                }
            }, $key);

        return $count;
    }

    /**
     * Best-effort conversion of a legacy date/datetime value into a Carbon
     * instance, tolerating the empty-string and zero-date junk ("0000-00-00")
     * that legacy MySQL dumps are full of.
     */
    private function toDate(mixed $value): ?Carbon
    {
        if ($value === null || $value === '' || ! is_scalar($value)) {
            return null;
        }

        $string = trim((string) $value);

        if ($string === '' || str_starts_with($string, '0000-00-00')) {
            return null;
        }

        try {
            return Carbon::parse($string);
        } catch (\Throwable) {
            return null;
        }
    }
}
