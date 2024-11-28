<?php

namespace App\Observers;

use App\Models\Account;
use App\Models\Trail;
use Illuminate\Support\Facades\Auth;

class AccountObserver
{
    /**
     * Handle the Account "created" event.
     */
    public function created(Account $account): void
    {
        Trail::create([
            'action' => 'created',
            'trailable_type' => Account::class,
            'trailable_id' => $account->id ?? null,
            'before' => null,
            'after' => $account->getDirty(),
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Handle the Account "updated" event.
     */
    public function updated(Account $account): void
    {
        Trail::create([
            'action' => 'updated',
            'trailable_type' => Account::class,
            'trailable_id' => $account->id ?? null,
            'before' => $account->getOriginal(),
            'after' => $account->getDirty(),
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Handle the Account "deleted" event.
     */
    public function deleted(Account $account): void
    {
        Trail::create([
            'action' => 'deleted',
            'trailable_type' => Account::class,
            'trailable_id' => $account->id ?? null,
            'before' => $account->getOriginal(),
            'after' => $account->getDirty(),
            'user_id' => Auth::id(),
        ]);
    }
}
