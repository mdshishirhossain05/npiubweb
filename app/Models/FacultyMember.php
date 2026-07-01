<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\RecordsActivity;
use Database\Factories\FacultyMemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * A teacher / staff member, optionally attached to a {@see Department}.
 * Their portrait lives in the media library.
 *
 * @property int $id
 * @property int|null $department_id
 * @property string $name
 * @property string $slug
 * @property string|null $designation
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $bio
 * @property int $sort_order
 * @property int|null $legacy_id
 */
class FacultyMember extends Model implements HasMedia
{
    /** @use HasFactory<FacultyMemberFactory> */
    use HasFactory;

    use HasSlug;
    use InteractsWithMedia;
    use RecordsActivity;

    protected $fillable = [
        'department_id',
        'name',
        'slug',
        'designation',
        'email',
        'phone',
        'bio',
        'sort_order',
        'legacy_id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('portrait')
            ->nonQueued()
            ->fit(Fit::Crop, 600, 600);
    }

    /**
     * Public URL of the portrait, or null when none has been uploaded.
     */
    public function photoUrl(): ?string
    {
        return $this->getFirstMedia('photo')?->getUrl('portrait');
    }
}
