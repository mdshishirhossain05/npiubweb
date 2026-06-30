<?php

namespace App\Models;

use App\Enums\ContentStatus;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\RecordsActivity;
use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Free-form static content (About, Mission, Admission info, ...).
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string|null $body
 * @property ContentStatus $status
 * @property Carbon|null $published_at
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property int|null $legacy_id
 */
class Page extends Model implements HasMedia
{
    /** @use HasFactory<PageFactory> */
    use HasFactory;

    use HasSlug;
    use InteractsWithMedia;
    use RecordsActivity;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'legacy_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
        ];
    }

    /**
     * @return array{0: string, 1: string}
     */
    protected static function slugConfig(): array
    {
        return ['title', 'slug'];
    }
}
