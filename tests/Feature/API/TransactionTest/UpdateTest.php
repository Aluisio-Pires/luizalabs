<?php

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

test('can update a transaction', function (): void {
    $user = User::factory()->has(
        Account::factory()->has(
            Transaction::factory()
        )
    )->create();

    $transaction = Transaction::whereHas('account', fn ($query) => $query->where('user_id', $user->id))->first();
    $request = [
        'description' => 'Test Message',
    ];
    $this->authRequest('put',
        route('api.v1.transactions.update', ['transaction' => $transaction->id]),
        Response::HTTP_OK,
        $request,
        $user
    );
});
