<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::inRandomOrder()->first();
        $company = Company::inRandomOrder()->first();
        // $positionId = Position::inRandomOrder()->first()->id;

        return [
            "full_name"=> fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'country'=> fake()->country(),
            'city'=> fake()->city(),
            'address'=> fake()->address(),
            'gender_id' => fake()->randomElement([
                1,
                2,
            ]),
            'user_id' => $userId ? $userId->id : null,
            'company_id' => $company ? $company->id : null,
            'position_id'=> 1,
            'super_visor_id'=> fake()->randomElement([
                1,
                2,
            ]),
        ];
    }
}
