<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Program>
 */
class ProgramFactory extends Factory
{
    protected $model = Program::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::title(fake()->unique()->words(3, true));

        return [
            'department_id' => Department::factory(),
            'name' => $name,
            'level' => fake()->randomElement(['Diploma', 'B.Sc', 'M.Sc']),
            'duration' => fake()->randomElement(['4 years', '2 years', '3 years']),
            'description' => fake()->optional()->paragraph(),
            'sort_order' => fake()->numberBetween(0, 50),
        ];
    }
}
