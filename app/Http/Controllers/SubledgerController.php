<?php

namespace App\Http\Controllers;

use App\Models\Subledger;
use Gate;
use Inertia\Inertia;

class SubledgerController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Subledger $subledger)
    {
        Gate::authorize('view', $subledger);

        return Inertia::render('Subledger/Show', [
            'subledger' => $subledger->load(['transaction.transactionType', 'transaction.account.user', 'transaction.payee.user', 'ledger']),
        ]);
    }
}
