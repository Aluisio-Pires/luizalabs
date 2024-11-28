<?php

use App\Models\Account;
use App\Models\Trail;
use App\Models\Transaction;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

pest()->group('api', 'account');

test('can index a trail', function (): void {
    $user = User::factory()->has(
        Account::factory()
    )->create();
    Trail::factory(4)->create();

    $account = Account::where('user_id', $user->id)->first();
    Trail::factory(3)->create([
        'trailable_id' => $account->id,
        'trailable_type' => Account::class,
        'action' => 'created',
        'user_id' => $user->id,
    ]);
    Trail::factory(2)->create([
        'trailable_id' => $account->id,
        'trailable_type' => Account::class,
        'action' => 'updated',
        'user_id' => $user->id,
    ]);

    $transaction = Transaction::factory()->create([
        'account_id' => $account->id,
        'type' => 'deposito',
    ]);
    Trail::factory(2)->create([
        'trailable_id' => $transaction->id,
        'trailable_type' => Transaction::class,
        'action' => 'updated',
        'user_id' => $user->id,
    ]);

    $response = $this->authRequest('get',
        route('api.v1.trails.index'),
        Response::HTTP_OK,
        [
            'action' => 'updated',
            'relation_name' => 'transactions',
            'relation_id' => $transaction->id,
        ],
        $user
    );

    $response->assertJsonCount(2, 'data.trails.data');

    $response = $this->authRequest('get',
        route('api.v1.trails.index'),
        Response::HTTP_OK,
        [
            'action' => 'updated',
        ],
        $user
    );

    $response->assertJsonCount(4, 'data.trails.data');

    $response = $this->authRequest('get',
        route('api.v1.trails.index'),
        Response::HTTP_OK,
        [
            'action' => 'created',
        ],
        $user
    );

    $response->assertJsonCount(3, 'data.trails.data');
});
