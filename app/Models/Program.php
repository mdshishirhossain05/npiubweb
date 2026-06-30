<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\RecordsActivity;
use Database\Factories\ProgramFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * An academic program/course offered by a {@see Department}.
 *
 * @property int $id
 * @property int|null $department_id
 * @property string $name
 * @property string $slug
 * @property string|null $level
 * @property string|null $duration
 * @property string|null $description
 * @property int $sort_order
 * @property int|null $legacy_id
 */
class Program extends Model
{
    /** @use HasFactory<ProgramFactory> */
    use HasFactory;

    use HasSlug;
    use RecordsActivity;

    protected $fillable = [
        'department_id',
        'name',
        'slug',
        'level',
        'duration',
        'description',
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
}
