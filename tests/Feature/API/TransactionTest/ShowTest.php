<?php

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

pest()->group('api', 'transaction');

test('can show a transaction', function (): void {
    $user = User::factory()->has(
        Account::factory()->has(
            Transaction::factory()
        )
    )->create();

    $transaction = Transaction::whereHas('account', fn ($query) => $query->where('user_id', $user->id))->first();

    $this->authRequest('get',
        route('api.v1.transactions.show', ['transaction' => $transaction->id]),
        Response::HTTP_OK,
        [],
        $user
    );
});
