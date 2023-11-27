<?php

namespace Database\Factories;

use App\Models\EmployeeDetail;
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
    protected $model = EmployeeDetail::class;
    public function definition(): array
    {
        return [
            //
        ];
    }
}
