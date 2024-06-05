<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InstructorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'FKLoginId' => 1,
            'firstname' => fake()->firstName(),
            'insertion' => null,
            'lastname' => fake()->lastName(),
            'isActive' => 1
        ];
    }
}
