<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\FacultyMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FacultyMember>
 */
class FacultyMemberFactory extends Factory
{
    protected $model = FacultyMember::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => Department::factory(),
            'name' => fake()->unique()->name(),
            'designation' => fake()->randomElement(['Lecturer', 'Assistant Professor', 'Associate Professor', 'Professor']),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'bio' => fake()->optional()->paragraph(),
            'sort_order' => fake()->numberBetween(0, 50),
        ];
    }
}
