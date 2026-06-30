<?php

namespace App\Models;

use App\Models\Concerns\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Notice extends Model implements HasMedia
{
    use HasFactory;
    use HasSeo;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'notice_date' => 'date',
        'is_important' => 'boolean',
        'views' => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        // Downloadable attachment (PDF, etc.) — file-only, no conversions.
        $this->addMediaCollection('attachment')->singleFile();
    }
}
