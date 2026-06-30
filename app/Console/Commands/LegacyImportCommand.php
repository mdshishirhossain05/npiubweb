<?php

namespace App\Console\Commands;

use App\Services\Legacy\LegacyImporter;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Config;
use Throwable;

class LegacyImportCommand extends Command
{
    protected $signature = 'legacy:import';

    protected $description = 'Import legacy CMS data into the new schema (idempotent; safe to re-run).';

    public function handle(DatabaseManager $db): int
    {
        /** @var string $connection */
        $connection = Config::get('legacy.connection', 'legacy');

        /** @var array<int, array<string, mixed>> $imports */
        $imports = (array) Config::get('legacy.imports', []);

        if ($imports === []) {
            $this->components->warn('No legacy imports are configured (see config/legacy.php).');

            return self::SUCCESS;
        }

        // Fail fast and clearly when the read-only legacy connection is not
        // wired up, rather than letting a cryptic PDO error surface mid-run.
        try {
            $db->connection($connection)->getPdo();
        } catch (Throwable $e) {
            $this->components->error(
                "Cannot reach the '{$connection}' database connection: {$e->getMessage()}",
            );

            return self::FAILURE;
        }

        $importer = new LegacyImporter($db, $connection, $imports);

        $this->components->info("Importing legacy data from the '{$connection}' connection…");

        $results = $importer->run(function (string $model, int $count): void {
            $this->components->twoColumnDetail(class_basename($model), (string) $count);
        });

        $total = array_sum($results);
        $this->newLine();
        $this->components->info("Done. Imported/updated {$total} record(s) across ".count($results).' model(s).');

        return self::SUCCESS;
    }
}
