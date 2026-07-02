<?php

namespace App\Models;

use App\Models\Concerns\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Department extends Model implements HasMedia
{
    use HasFactory;
    use HasSeo;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'priority' => 'integer',
        'established_year' => 'integer',
    ];

    /**
     * Active departments for navigation/footer, cached to avoid a query on
     * every page load. Busted automatically when a department changes.
     */
    public static function activeNav()
    {
        return Cache::rememberForever('departments.active_nav', fn () => static::query()
            ->where('is_active', true)
            ->orderBy('priority')->orderBy('name')
            ->get(['id', 'name', 'slug', 'short_name']));
    }

    protected static function booted(): void
    {
        $flush = fn () => Cache::forget('departments.active_nav');
        static::saved($flush);
        static::deleted($flush);
    }

    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(600)->format('webp')->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }
}
