<?php

namespace App\Models;

use App\Models\Concerns\RecordsActivity;
use Database\Factories\SlideFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * A homepage hero/carousel slide. The image is the payload and lives in the
 * media library; everything else is optional caption/link metadata.
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $link_url
 * @property int $sort_order
 * @property bool $is_active
 * @property int|null $legacy_id
 */
class Slide extends Model implements HasMedia
{
    /** @use HasFactory<SlideFactory> */
    use HasFactory;

    use InteractsWithMedia;
    use RecordsActivity;

    protected $fillable = [
        'title',
        'subtitle',
        'link_url',
        'sort_order',
        'is_active',
        'legacy_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('hero')
            ->nonQueued()
            ->fit(Fit::Crop, 1920, 1080);
    }

    /**
     * Public URL of the hero image, or null when no image has been uploaded.
     */
    public function imageUrl(): ?string
    {
        $media = $this->getFirstMedia('image');

        return $media?->getUrl('hero');
    }
}
