<?php

use App\Models\Account;
use App\Models\Subledger;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

test('can update a subledger', function (): void {
    $user = User::factory()->has(
        Account::factory()->has(
            Subledger::factory()
        )
    )->create();
    $subledger = Subledger::whereHas('account', fn ($query) => $query->where('user_id', $user->id))->get()->first();

    $request = [
        'name' => 'Test Subledger',
        'description' => 'Test Subledger Description',
    ];

    $this->authRequest('put',
        route('api.subledgers.update', ['subledger' => $subledger->id]),
        Response::HTTP_OK,
        $request,
        $user
    );
});
