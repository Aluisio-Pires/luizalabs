<?php

use App\Models\Account;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

pest()->group('api', 'account');

test('can show an account', function (): void {
    $user = User::factory()->has(
        Account::factory()
    )->create();

    $account = Account::where('user_id', $user->id)->first();

    $this->authRequest('get',
        route('api.v1.accounts.show', ['account' => $account->id]),
        Response::HTTP_OK,
        [],
        $user
    );
});
