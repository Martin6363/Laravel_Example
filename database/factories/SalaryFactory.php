<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Salary>
 */
class SalaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employee = Employee::inRandomOrder()->first();
        $employeeId = $employee ? $employee->id : null;
        return [
            'amount' => fake()->numberBetween(1000, 10000),
            'emp_id' => $employeeId,
            'bonus'=> null,
        ];
    }
}
