<?php

namespace App\Models;

use App\Models\Concerns\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory;
    use HasSeo;
    use SoftDeletes;

    public const LEVEL_UNDERGRADUATE = 'undergraduate';

    public const LEVEL_GRADUATE = 'graduate';

    public const LEVEL_DIPLOMA = 'diploma';

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
