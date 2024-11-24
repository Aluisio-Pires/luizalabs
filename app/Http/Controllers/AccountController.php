<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    /**
     * Retorna uma lista de contas.
     */
    public function index(): Response
    {
        Gate::authorize('viewAny', Account::class);
        $accounts = Account::with(['user', 'transactions', 'inflows'])
            ->where('user_id', auth()->user()->id)
            ->paginate(20);

        return Inertia::render('Account/Index', [
            'accounts' => Inertia::merge(fn () => $accounts->items()),
            'currentPage' => $accounts->currentPage(),
        ]);
    }

    /**
     * Mostra página de criação de contas.
     */
    public function create()
    {
        Gate::authorize('create', Account::class);

        return Inertia::render('Account/Create');
    }

    /**
     * Cria uma nova conta
     */
    public function store(StoreAccountRequest $request): RedirectResponse
    {
        Gate::authorize('create', Account::class);
        $account = Account::create([
            'user_id' => auth()->user()->id,
            'balance' => $request->balance,
            'credit_limit' => $request->credit_limit,
        ]);

        return redirect()->route('accounts.show', $account);
    }

    /**
     * Mostra os dados da conta.
     */
    public function show(Account $account): Response
    {
        Gate::authorize('view', $account);
        $account->load(['user', 'transactions', 'inflows']);

        return Inertia::render('Account/Show', ['account' => $account]);
    }

    /**
     * Exibe a página de editar a conta.
     */
    public function edit(Account $account)
    {
        Gate::authorize('update', $account);
        //
    }

    /**
     * Atualiza a conta.
     */
    public function update(UpdateAccountRequest $request, Account $account): JsonResponse
    {
        Gate::authorize('update', $account);
        $validated = $request->validated();
        $account->update($validated);

        return response()->json($account);
    }

    /**
     * Desativa a conta.
     */
    public function destroy(Account $account): JsonResponse
    {
        Gate::authorize('delete', $account);
        $account->delete();

        return response()->json(null, 204);
    }

    /**
     * Restaura a conta.
     */
    public function restore(Account $account): JsonResponse
    {
        Gate::authorize('restore', $account);
        $account->restore();

        return response()->json($account);
    }

    /**
     * Mostra página de criação de Transações.
     */
    public function createTransaction(Account $account)
    {
        Gate::authorize('create', Transaction::class);
        $types = TransactionType::all();

        return Inertia::render('Transaction/Create', [
            'account' => $account,
            'types' => $types,
        ]);
    }
}
