<?php

use App\Models\Account;
use App\Models\Fee;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

pest()->group('api', 'transaction');

test('can create transactions', function (): void {
    $user = User::factory()->create();
    $account = Account::factory()->create([
        'user_id' => $user->id,
        'balance' => 1000,
        'credit_limit' => 1000,
    ])->fresh();
    Fee::factory()->create([
        'name' => 'Test Fee',
        'description' => 'Test Fee Description',
        'type' => 'fixed',
        'value' => 5,
        'transaction_type_id' => TransactionType::where('slug', 'saque')->first()->getKey(),
    ]);
    Fee::factory()->create([
        'name' => 'Test Fee',
        'description' => 'Test Fee Description',
        'type' => 'percentage',
        'value' => 10,
        'transaction_type_id' => TransactionType::where('slug', 'saque')->first()->getKey(),
    ]);

    $request = [
        'description' => 'Teste de Saque',
        'type' => 'saque',
        'amount' => '100.00',
        'account_number' => $account->number,
    ];

    $response = $this->authRequest('post',
        route('api.v1.transactions.store'),
        Response::HTTP_CREATED,
        $request,
        $user
    );

    $transaction = Transaction::where('id', $response->json('transaction.id'))->first();

    expect($transaction->total === 115.00)->toBeTrue();
});

test('cant create transactions with wrong account', function (): void {
    $user = User::factory()->create();
    $account = Account::factory()->create([
        'balance' => 1000,
        'credit_limit' => 1000,
    ])->fresh();
    Fee::factory()->create([
        'name' => 'Test Fee',
        'description' => 'Test Fee Description',
        'type' => 'fixed',
        'value' => 5,
        'transaction_type_id' => TransactionType::where('slug', 'saque')->first()->getKey(),
    ]);
    Fee::factory()->create([
        'name' => 'Test Fee',
        'description' => 'Test Fee Description',
        'type' => 'percentage',
        'value' => 10,
        'transaction_type_id' => TransactionType::where('slug', 'saque')->first()->getKey(),
    ]);

    $request = [
        'description' => 'Teste de Saque',
        'type' => 'saque',
        'amount' => '100.00',
        'account_number' => $account->number,
    ];

    $this->authRequest('post',
        route('api.v1.transactions.store'),
        Response::HTTP_UNPROCESSABLE_ENTITY,
        $request,
        $user
    );
});

test('can create transactions is idempotent', function (): void {
    $user = User::factory()->create();
    $account = Account::factory()->create([
        'user_id' => $user->id,
        'balance' => 1000,
        'credit_limit' => 1000,
    ])->fresh();
    Fee::factory()->create([
        'name' => 'Test Fee',
        'description' => 'Test Fee Description',
        'type' => 'fixed',
        'value' => 5,
        'transaction_type_id' => TransactionType::where('slug', 'saque')->first()->getKey(),
    ]);
    Fee::factory()->create([
        'name' => 'Test Fee',
        'description' => 'Test Fee Description',
        'type' => 'percentage',
        'value' => 10,
        'transaction_type_id' => TransactionType::where('slug', 'saque')->first()->getKey(),
    ]);

    $request = [
        'description' => 'Teste de Saque',
        'type' => 'saque',
        'amount' => '100.00',
        'account_number' => $account->number,
    ];

    $response = $this->authRequest('post',
        route('api.v1.transactions.store'),
        Response::HTTP_CREATED,
        $request,
        $user
    );

    $this->authRequest('post',
        route('api.v1.transactions.store'),
        Response::HTTP_CONFLICT,
        $request,
        $user
    );

    $transaction = Transaction::where('id', $response->json('transaction.id'))->first();

    expect($transaction->total === 115.00)->toBeTrue();
});
