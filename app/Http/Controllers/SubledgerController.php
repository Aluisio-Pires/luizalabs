<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSubledgerRequest;
use App\Models\Subledger;
use Gate;
use Inertia\Inertia;

class SubledgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subledger $subledger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubledgerRequest $request, Subledger $subledger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subledger $subledger)
    {
        //
    }
}
