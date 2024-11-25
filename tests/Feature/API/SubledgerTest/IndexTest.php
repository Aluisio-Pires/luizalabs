<?php

use App\Models\Account;
use App\Models\Subledger;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

test('can index subledgers', function (): void {
    $user = User::factory()->has(
        Account::factory()->has(
            Subledger::factory()->count(3)
        )
    )->create();

    Subledger::factory()->count(3)->create();
    $response = $this->authRequest('get',
        route('api.v1.subledgers.index'),
        Response::HTTP_OK,
        [],
        $user
    );

    $response->assertJsonCount(3, 'data');
});
