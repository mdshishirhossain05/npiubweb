<?php

namespace App\Models;

use App\Enums\ContentStatus;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Publishable;
use App\Models\Concerns\RecordsActivity;
use Database\Factories\NoticeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Official notices / circulars, usually carrying a downloadable attachment
 * (PDF) stored in the media library.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $body
 * @property Carbon|null $notice_date
 * @property bool $is_pinned
 * @property ContentStatus $status
 * @property Carbon|null $published_at
 * @property int|null $legacy_id
 */
class Notice extends Model implements HasMedia
{
    /** @use HasFactory<NoticeFactory> */
    use HasFactory;

    use HasSlug;
    use InteractsWithMedia;
    use Publishable;
    use RecordsActivity;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'notice_date',
        'is_pinned',
        'status',
        'published_at',
        'legacy_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'notice_date' => 'date',
            'is_pinned' => 'boolean',
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
