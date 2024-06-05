<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'FKLoginId' => 2,
            'firstname' => fake()->firstName(),
            'insertion' => null,
            'lastname' => fake()->lastName(),
            'street' => fake()->streetName(),
            'house_number' => fake()->numberBetween(1, 255),
            'postcode' => (fake()->numberBetween(1000,9999) . fake()->randomLetter() . fake()->randomLetter()),
            'city' => fake()->city(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
