<?php

use App\Models\Account;
use App\Models\Subledger;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

test('can show a subledger', function (): void {
    $user = User::factory()->has(
        Account::factory()->has(
            Subledger::factory()
        )
    )->create();
    $subledger = Subledger::whereHas('account', fn ($query) => $query->where('user_id', $user->id))->get()->first();

    $this->authRequest('get',
        route('api.v1.subledgers.show', ['subledger' => $subledger->id]),
        Response::HTTP_OK,
        [],
        $user
    );
});
