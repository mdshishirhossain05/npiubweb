<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

/**
 * Provides sensible SEO defaults for content models that carry
 * `meta_title` / `meta_description` columns.
 */
trait HasSeo
{
    public function seoTitle(): string
    {
        return $this->meta_title
            ?: (string) ($this->title ?? $this->name ?? config('app.name'));
    }

    public function seoDescription(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }

        $source = $this->excerpt
            ?? $this->summary
            ?? $this->description
            ?? $this->biography
            ?? $this->content
            ?? '';

        return Str::limit(trim(strip_tags((string) $source)), 155);
    }
}
