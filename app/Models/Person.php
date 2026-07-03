<?php

namespace App\Models;

use App\Models\Concerns\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Person extends Model implements HasMedia
{
    use HasFactory;
    use HasSeo;
    use InteractsWithMedia;
    use SoftDeletes;

    public const TYPE_FACULTY = 'faculty';

    public const TYPE_OFFICER = 'officer';

    public const TYPE_LEADERSHIP = 'leadership';

    protected $table = 'people';

    protected $guarded = ['id'];

    protected $casts = [
        'degrees' => 'array',
        'research_interests' => 'array',
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeFaculty($query)
    {
        return $query->where('type', self::TYPE_FACULTY);
    }

    /**
     * Active leadership/office holders for the navigation menu, cached.
     */
    public static function leadershipNav()
    {
        return Cache::rememberForever('people.leadership_nav', fn () => static::query()
            ->where('type', self::TYPE_LEADERSHIP)
            ->where('is_active', true)
            ->orderBy('priority')->orderBy('name')
            ->get(['name', 'slug', 'position']));
    }

    protected static function booted(): void
    {
        $flush = fn () => Cache::forget('people.leadership_nav');
        static::saved($flush);
        static::deleted($flush);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(400)->height(400)->format('webp')->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }
}
