<?php

use App\Models\Account;
use App\Models\Fee;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

test('can create accounts', function (): void {
    $user = User::factory()->create();
    $request = [
        'user_id' => $user->id,
        'balance' => "1000.00",
        'credit_limit' => "1000.00",
    ];

    $response = $this->authRequest('post',
        route('api.accounts.store'),
        Response::HTTP_CREATED,
        $request,
        $user
    );
});
