<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = $this->faker->numberBetween(1000, 100000);
        $fee = $this->faker->numberBetween(0, 1000);
        $total = $amount + $fee;

        return [
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['deposito', 'saque', 'transferencia']),
            'status' => $this->faker->randomElement(['pendente', 'sucesso', 'falha']),
            'message' => $this->faker->optional()->sentence(),
            'amount' => $amount,
            'fee' => $fee,
            'total' => $total,
            'transaction_type_id' => TransactionType::where('slug', $this->faker->randomElement(['deposito', 'saque', 'transferencia']))->first()->getKey(),
            'account_id' => Account::factory(),
            'payee_id' => Account::factory(),
        ];
    }
}
