<?php

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

test('can index transactions', function (): void {
    $user = User::factory()->has(
        Account::factory()->has(
            Transaction::factory()->count(4)
        )
    )->create();
    $response = $this->authRequest('get',
        route('api.transactions.index'),
        Response::HTTP_OK,
        [],
        $user
    );

    $response->assertJsonCount(4, 'data');
});
