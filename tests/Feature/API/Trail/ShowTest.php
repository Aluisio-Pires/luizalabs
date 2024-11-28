<?php

use App\Models\Account;
use App\Models\Trail;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

pest()->group('api', 'trail');

test('can index a trail', function (): void {
    $user = User::factory()->has(
        Account::factory()
    )->create();

    $account = Account::where('user_id', $user->id)->first();
    $trail = Trail::factory()->create([
        'trailable_id' => $account->id,
        'trailable_type' => Account::class,
        'action' => 'created',
        'user_id' => $user->id,
    ]);

    $this->authRequest('get',
        route('api.v1.trails.show', ['trail' => $trail->id]),
        Response::HTTP_OK,
        [],
        $user
    );
});
