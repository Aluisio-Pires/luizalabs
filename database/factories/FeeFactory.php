<?php

namespace Database\Factories;

use App\Models\Fee;
use App\Models\TransactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fee>
 */
class FeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['fixed', 'percentage']),
            'value' => $this->faker->numberBetween(1000000, 100000000),
            'transaction_type_id' => TransactionType::factory(),
        ];
    }
}
