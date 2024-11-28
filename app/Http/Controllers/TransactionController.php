<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Services\TransactionService;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    /**
     * Mostra página de criação de Transações.
     */
    public function create(): Response
    {
        Gate::authorize('create', Transaction::class);

        return Inertia::render('Account/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        Gate::authorize('create', Transaction::class);
        $service = new TransactionService;
        $service->create($request->validated());

        return redirect(route('accounts.index'));
    }
}
