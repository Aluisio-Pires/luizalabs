<?php

use App\Models\Account;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

test('can index account', function (): void {
    $user = User::factory()->has(
        Account::factory()->count(3)
    )->create();
    $response = $this->authRequest('get',
        route('api.accounts.index'),
        Response::HTTP_OK,
        [],
        $user
    );

    $response->assertJsonCount(3, 'data');
});
