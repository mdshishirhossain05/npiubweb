<?php

namespace App\Console\Commands;

use App\Models\Alumnus;
use App\Models\GalleryImage;
use App\Models\News;
use App\Models\Notice;
use App\Models\Person;
use App\Models\Research;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Throwable;

class ImportLegacyMedia extends Command
{
    protected $signature = 'legacy:media
        {--base=* : Source base director(ies) that legacy image paths are relative to}
        {--fresh : Re-attach even if the model already has media in the collection}';

    protected $description = 'Copy legacy image/file paths into the media library (originals are preserved).';

    private int $ok = 0;

    private int $skipped = 0;

    private int $missing = 0;

    private int $failed = 0;

    public function handle(): int
    {
        $bases = collect($this->option('base'))
            ->merge([
                config('legacy.media_path'),
                '/home2/owdfyvte/laravel_app/storage/app/public',
                '/home2/owdfyvte/public_html',
                base_path('../laravel_app/storage/app/public'),
            ])
            ->filter(fn ($p) => $p && is_dir($p))
            ->unique()->values()->all();

        if (empty($bases)) {
            $this->error('No valid source directory found. Pass one with --base=/path/to/old/storage/app/public');

            return self::FAILURE;
        }

        $this->info('Source directories: '.implode(', ', $bases));
        $fresh = (bool) $this->option('fresh');

        $this->attach(Person::query()->whereNotNull('legacy_image'), [['legacy_image', 'photo']], $bases, $fresh);
        $this->attach(Alumnus::query()->whereNotNull('legacy_image'), [['legacy_image', 'photo']], $bases, $fresh);
        $this->attach(News::query()->whereNotNull('legacy_image'), [['legacy_image', 'cover'], ['legacy_author_image', 'author']], $bases, $fresh);
        $this->attach(Research::query()->whereNotNull('legacy_image'), [['legacy_image', 'cover'], ['legacy_author_image', 'author']], $bases, $fresh);
        $this->attach(Notice::query()->whereNotNull('legacy_file'), [['legacy_file', 'attachment']], $bases, $fresh);
        $this->attach(GalleryImage::query()->whereNotNull('legacy_image'), [['legacy_image', 'image']], $bases, $fresh);

        $this->newLine();
        $this->table(['Attached', 'Skipped (had media)', 'Missing files', 'Failed'],
            [[$this->ok, $this->skipped, $this->missing, $this->failed]]);

        return self::SUCCESS;
    }

    /**
     * @param  array<int, array{0:string,1:string}>  $map  [legacy column, media collection]
     * @param  array<int, string>  $bases
     */
    private function attach(Builder $query, array $map, array $bases, bool $fresh): void
    {
        foreach ($query->cursor() as $model) {
            if (! $model instanceof HasMedia) {
                continue;
            }

            foreach ($map as [$column, $collection]) {
                $relative = $model->{$column};
                if (blank($relative)) {
                    continue;
                }

                if (! $fresh && $model->hasMedia($collection)) {
                    $this->skipped++;

                    continue;
                }

                $file = $this->resolve($relative, $bases);
                if (! $file) {
                    $this->missing++;

                    continue;
                }

                try {
                    if ($fresh) {
                        $model->clearMediaCollection($collection);
                    }
                    $model->addMedia($file)->preservingOriginal()->toMediaCollection($collection);
                    $this->ok++;
                } catch (Throwable $e) {
                    $this->failed++;
                    $this->warn("  failed {$relative}: ".$e->getMessage());
                }
            }
        }
    }

    /**
     * @param  array<int, string>  $bases
     */
    private function resolve(string $relative, array $bases): ?string
    {
        $relative = ltrim($relative, '/');
        foreach ($bases as $base) {
            $path = rtrim($base, '/').'/'.$relative;
            if (is_file($path)) {
                return $path;
            }
            // Some legacy paths omit the storage subfolder; try the basename too.
            $alt = rtrim($base, '/').'/'.basename($relative);
            if (is_file($alt)) {
                return $alt;
            }
        }

        return null;
    }
}
