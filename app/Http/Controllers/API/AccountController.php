<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreAccountRequest;
use App\Models\Account;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends APIController
{
    /**
     * Recupera uma lista paginada de contas do usuário.
     *
     * @Request({
     *       tags: Conta
     *  })
     */
    public function index(): JsonResponse
    {
        Gate::authorize('viewAny', Account::class);

        $accounts = Account::query()
            ->where('user_id', auth()->user()->id)
            ->paginate(20);

        return response()->json($accounts);
    }

    /**
     * Cria uma nova conta.
     *
     * @Request({
     *        tags: Conta
     *   })
     */
    public function store(StoreAccountRequest $request): JsonResponse
    {
        Gate::authorize('create', Account::class);
        $account = Account::create([
            'user_id' => auth()->user()->id,
            'balance' => $request->balance,
            'credit_limit' => $request->credit_limit,
        ]);

        return response()->json([
            'message' => 'Conta criada com sucesso',
            'account' => $account,
        ], Response::HTTP_CREATED);
    }

    /**
     * Recupera os dados de uma conta específica.
     *
     * @Request({
     *        tags: Conta
     *   })
     */
    public function show(Account $account): JsonResponse
    {
        Gate::authorize('view', $account);

        return $this->response(['account' => $account->load(['transactions', 'inflows', 'subledgers', 'trails'])]);
    }
}
