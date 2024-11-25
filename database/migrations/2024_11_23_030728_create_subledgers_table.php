<?php

use App\Models\Account;
use App\Models\Ledger;
use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subledgers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('value')->default(0); //Valor em Microns
            $table->bigInteger('fee')->default(0); //Valor em Microns

            $table->foreignIdFor(Ledger::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Transaction::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Account::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subledgers');
    }
};
