<?php

namespace App\Observers;

use App\Models\Trail;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        Trail::create([
            'action' => 'created',
            'trailable_type' => Transaction::class,
            'trailable_id' => $transaction->id ?? null,
            'before' => null,
            'after' => $transaction->getDirty(),
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        Trail::create([
            'action' => 'updated',
            'trailable_type' => Transaction::class,
            'trailable_id' => $transaction->id ?? null,
            'before' => $transaction->getOriginal(),
            'after' => $transaction->getDirty(),
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        Trail::create([
            'action' => 'deleted',
            'trailable_type' => Transaction::class,
            'trailable_id' => $transaction->id ?? null,
            'before' => $transaction->getOriginal(),
            'after' => $transaction->getDirty(),
            'user_id' => Auth::id(),
        ]);
    }
}
