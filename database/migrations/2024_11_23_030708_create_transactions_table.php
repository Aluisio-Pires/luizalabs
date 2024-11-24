<?php

use App\Models\Account;
use App\Models\TransactionType;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->string('type');
            $table->string('status');
            $table->text('message')->nullable();

            $table->bigInteger('amount')->default(0); //Valor em Microns
            $table->bigInteger('fee')->default(0); //Valor em Microns
            $table->bigInteger('total')->default(0); //Valor em Microns

            $table->foreignIdFor(TransactionType::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Account::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignId('payee_id')->nullable()->constrained('accounts')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
