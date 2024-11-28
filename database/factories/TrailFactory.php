<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trail>
 */
class TrailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'action' => $this->faker->randomElement(['created', 'updated', 'deleted']),
            'trailable_type' => $this->faker->randomElement([Account::class, Transaction::class]),
            'trailable_id' => Account::factory(),
            'before' => null,
            'after' => null,
            'user_id' => User::factory(),
        ];
    }
}
