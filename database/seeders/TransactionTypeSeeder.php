<?php

namespace Database\Seeders;

use App\Models\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransactionType::create([
            'name' => 'Deposito',
            'slug' => 'deposito',
            'description' => 'Adiciona fundos ao saldo da conta',
        ]);
        TransactionType::create([
            'name' => 'Saque',
            'slug' => 'saque',
            'description' => 'Retira fundos do saldo da conta e limite de crédito',
        ]);
        TransactionType::create([
            'name' => 'Transferência',
            'slug' => 'transferencia',
            'description' => 'Transfere fundos do saldo da conta e limite de crédito para outra conta',
        ]);
    }
}
