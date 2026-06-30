<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\RecordsActivity;
use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Academic department. Owns its {@see Program}s and {@see FacultyMember}s.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $short_name
 * @property string|null $description
 * @property int $sort_order
 * @property int|null $legacy_id
 */
class Department extends Model
{
    /** @use HasFactory<DepartmentFactory> */
    use HasFactory;

    use HasSlug;
    use RecordsActivity;

    protected $fillable = [
        'name',
        'slug',
        'short_name',
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
     * @return HasMany<Program, $this>
     */
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    /**
     * @return HasMany<FacultyMember, $this>
     */
    public function facultyMembers(): HasMany
    {
        return $this->hasMany(FacultyMember::class);
    }
}
