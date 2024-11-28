<?php

use App\Models\Account;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

pest()->group('web', 'account');

test('can createTransactions accounts', function (): void {
    $user = User::factory()->create();
    $account = Account::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->authRequest('get',
        route('accounts.createTransaction', ['account' => $account->id]),
        Response::HTTP_OK,
        [],
        $user
    );
});
