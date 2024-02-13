<?php

namespace Database\Factories;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departmentId = Department::inRandomOrder()->first()->id;
        return [
            "name"=> fake()->company(),
            "description"=> fake()->paragraph(),
            "department_id"=> $departmentId,
        ];
    }
}
