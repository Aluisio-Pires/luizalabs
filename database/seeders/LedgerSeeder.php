<?php

namespace Database\Seeders;

use App\Models\Ledger;
use Illuminate\Database\Seeder;

class LedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ledger::create([
            'name' => 'Entrada',
            'description' => 'Entrada de dinheiro na conta',
        ]);
        Ledger::create([
            'name' => 'Saída',
            'description' => 'Saída de dinheiro na conta',
        ]);
    }
}
