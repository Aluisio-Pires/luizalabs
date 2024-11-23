<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'balance' => $this->faker->numberBetween(0, 1000000),
            'credit_limit' => $this->faker->numberBetween(0, 500000),
            'user_id' => User::factory(),
            'deleted_at' => null,
        ];
    }
}
