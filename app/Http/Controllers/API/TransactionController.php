<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Services\TransactionService;
use App\Models\Transaction;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends APIController
{
    /**
     * Recupera uma lista paginada de transações do usuário.
     *
     * @Request({
     *          tags: Transação
     *     })
     */
    public function index()
    {
        Gate::authorize('viewAny', Transaction::class);

        $transactions = Transaction::query()
            ->whereHas('account', fn ($query) => $query->where('user_id', auth()->user()->id))
            ->orWhereHas('payee', fn ($query) => $query->where('user_id', auth()->user()->id))
            ->orderBy('id', 'desc')
            ->paginate(20);

        return response()->json($transactions);
    }

    /**
     * Cria uma nova transação.
     *
     * @Request({
     *           tags: Transação
     *      })
     */
    public function store(StoreTransactionRequest $request)
    {
        Gate::authorize('create', Transaction::class);
        $service = new TransactionService;
        $transaction = $service->create($request->validated());

        return response()->json([
            'message' => 'Transação realizada com sucesso',
            'transaction' => $transaction,
        ], Response::HTTP_CREATED);
    }

    /**
     * Recupera os dados de uma transação específica.
     *
     * @Request({
     *           tags: Transação
     *      })
     */
    public function show(Transaction $transaction)
    {
        Gate::authorize('view', $transaction);

        return $this->response(['transaction' => $transaction]);
    }

    /**
     * Atualiza os dados de uma transação especifica.
     *
     * @Request({
     *           tags: Transação
     *      })
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        Gate::authorize('update', $transaction);

        $transaction->update($request->validated());

        return $this->response(['transaction' => $transaction]);
    }
}
