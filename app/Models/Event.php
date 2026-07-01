<?php

namespace App\Models;

use App\Enums\ContentStatus;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Publishable;
use App\Models\Concerns\RecordsActivity;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Calendar events (seminars, convocations, ...).
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property Carbon|null $starts_at
 * @property Carbon|null $ends_at
 * @property string|null $location
 * @property ContentStatus $status
 * @property Carbon|null $published_at
 * @property int|null $legacy_id
 */
class Event extends Model implements HasMedia
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    use HasSlug;
    use InteractsWithMedia;
    use Publishable;
    use RecordsActivity;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'starts_at',
        'ends_at',
        'location',
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
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
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
