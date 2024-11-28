<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Models\Account;
use App\Models\Subledger;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class AccountController extends Controller
{
    /**
     * Retorna uma lista de contas.
     */
    public function index(): InertiaResponse
    {
        Gate::authorize('viewAny', Account::class);
        $accounts = Account::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return Inertia::render('Account/Index', [
            'accounts' => Inertia::merge(fn () => $accounts->items()),
            'currentPage' => $accounts->currentPage(),
        ]);
    }

    /**
     * Mostra página de criação de contas.
     */
    public function create(): InertiaResponse
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

        return redirect(route('accounts.show', $account));
    }

    /**
     * Mostra os dados da conta.
     */
    public function show(Account $account): InertiaResponse
    {
        Gate::authorize('view', $account);
        $subledgers = Subledger::with('ledger')->where('account_id', $account->id)->orderBy('created_at', 'desc')->paginate(3);

        return Inertia::render('Account/Show', [
            'account' => $account,
            'subledgers' => Inertia::merge(fn () => $subledgers->items()),
            'currentPage' => $subledgers->currentPage(),
        ]);
    }

    /**
     * Mostra página de criação de Transações.
     */
    public function createTransaction(Account $account): InertiaResponse
    {
        Gate::authorize('create', Transaction::class);
        $types = TransactionType::all();

        return Inertia::render('Transaction/Create', [
            'account' => $account,
            'types' => $types,
        ]);
    }
}
