<?php

namespace Database\Factories;

use App\Enums\BillStatusEnum;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bill>
 */
class BillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_time' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'note' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(BillStatusEnum::asArray()),
            'total' => $this->faker->randomDigitNotZero(),
            'customer_id' => Customer::query()->inRandomOrder()->value('id'),
        ];
    }
}
