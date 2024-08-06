<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'gender' => $this->faker->boolean(),
            'dob' => $this->faker->dateTimeBetween('-30 years', '-18 years'),
            'email' => $this->faker->email(),
            'password' => $this->faker->name(),
            'address' => $this->faker->streetAddress(),
        ];
    }
}
