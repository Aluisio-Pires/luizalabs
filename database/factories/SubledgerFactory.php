<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Ledger;
use App\Models\Subledger;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subledger>
 */
class SubledgerFactory extends Factory
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
            'value' => $this->faker->numberBetween(10000, 100000000),
            'fee' => $this->faker->numberBetween(10000, 100000000),
            'ledger_id' => Ledger::factory(),
            'transaction_id' => Transaction::factory(),
            'account_id' => Account::factory(),
        ];
    }
}
