<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = 'Department of '.Str::title(fake()->unique()->words(2, true));

        return [
            'name' => $name,
            'short_name' => Str::upper(fake()->lexify('???')),
            'description' => fake()->optional()->paragraph(),
            'sort_order' => fake()->numberBetween(0, 50),
        ];
    }
}
