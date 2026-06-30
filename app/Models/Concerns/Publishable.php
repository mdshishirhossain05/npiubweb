<?php

namespace App\Models\Concerns;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Adds a `published` query scope to editorial models that carry a
 * {@see ContentStatus} and an optional `published_at` timestamp.
 *
 * A row is considered public when it is marked Published and either has no
 * scheduled time or that time has already passed — so the same scope powers
 * both "draft hidden from the site" and simple future-dated scheduling.
 *
 * @phpstan-require-extends Model
 */
trait Publishable
{
    /**
     * @param  Builder<static>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query
            ->where('status', ContentStatus::Published)
            ->where(function (Builder $query): void {
                $query
                    ->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Whether this individual record is publicly visible right now — the
     * single-model mirror of {@see Publishable::scopePublished()}, used after
     * route-model binding has already fetched the row.
     */
    public function isPublished(): bool
    {
        if ($this->getAttribute('status') !== ContentStatus::Published) {
            return false;
        }

        $publishedAt = $this->getAttribute('published_at');

        return ! $publishedAt instanceof Carbon || $publishedAt->isPast();
    }
}
