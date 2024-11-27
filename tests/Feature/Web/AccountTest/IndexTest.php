<?php

use App\Models\Account;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

test('can index account', function (): void {
    $user = User::factory()->has(
        Account::factory()->count(3)
    )->create();
    $this->authRequest('get',
        route('accounts.index'),
        Response::HTTP_OK,
        [],
        $user
    );
});
