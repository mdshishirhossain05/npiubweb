<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Generates a URL-friendly, table-unique slug on creation when one is not
 * supplied. Slugs are intentionally *not* regenerated on update so that
 * published URLs stay stable once content goes live.
 *
 * Models source the slug from a `title` or `name` column; override
 * {@see HasSlug::slugConfig()} to point at a different column pair.
 */
trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::creating(function (Model $model): void {
            [$sourceColumn, $slugColumn] = static::slugConfig();

            if (! empty($model->getAttribute($slugColumn))) {
                return;
            }

            $model->setAttribute(
                $slugColumn,
                static::generateUniqueSlug((string) $model->getAttribute($sourceColumn), $slugColumn),
            );
        });
    }

    /**
     * The [source column, slug column] pair this model slugs from.
     *
     * @return array{0: string, 1: string}
     */
    protected static function slugConfig(): array
    {
        return ['name', 'slug'];
    }

    protected static function generateUniqueSlug(string $value, string $slugColumn): string
    {
        $base = Str::slug($value);

        if ($base === '') {
            $base = Str::lower(Str::random(8));
        }

        $slug = $base;
        $suffix = 2;

        while (static::query()->where($slugColumn, $slug)->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
