<?php

use App\Http\Services\TransactionService;
use App\Models\Account;
use App\Models\Fee;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

pest()->group('web', 'transaction');

test('can store saque transactions', function (): void {
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
        route('transactions.store'),
        Response::HTTP_FOUND,
        $request,
        $user
    );
    $transaction = Transaction::where('account_id', $account->id)->first();

    expect($transaction->total === 115.00)->toBeTrue();
});

test('cant store saque with not enough cash transactions', function (): void {
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
        'amount' => '10000.00',
        'account_number' => $account->number,
    ];

    $response = $this->authRequest('post',
        route('transactions.store'),
        Response::HTTP_FOUND,
        $request,
        $user
    );
    $transaction = Transaction::where('account_id', $account->id)->first();

    expect($transaction->total === 11005.00)->toBeTrue();
});

test('can store transferencia transactions', function (): void {
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
        'transaction_type_id' => TransactionType::where('slug', 'transferencia')->first()->getKey(),
    ]);
    Fee::factory()->create([
        'name' => 'Test Fee',
        'description' => 'Test Fee Description',
        'type' => 'percentage',
        'value' => 10,
        'transaction_type_id' => TransactionType::where('slug', 'transferencia')->first()->getKey(),
    ]);

    $account2 = Account::factory()->create()->fresh();

    $request = [
        'description' => 'Teste de Saque',
        'type' => 'transferencia',
        'amount' => '100.00',
        'account_number' => $account->number,
        'payee_number' => $account2->number,
    ];

    $response = $this->authRequest('post',
        route('transactions.store'),
        Response::HTTP_FOUND,
        $request,
        $user
    );
    $transaction = Transaction::where('account_id', $account->id)->first();

    expect($transaction->total === 115.00)->toBeTrue();
});

test('can store deposito transactions', function (): void {
    $user = User::factory()->create();
    $account = Account::factory()->create([
        'user_id' => $user->id,
        'balance' => 1000,
        'credit_limit' => 1000,
    ])->fresh();

    $request = [
        'description' => 'Teste de Saque',
        'type' => 'deposito',
        'amount' => '100.00',
        'account_number' => $account->number,
    ];

    $response = $this->authRequest('post',
        route('transactions.store'),
        Response::HTTP_FOUND,
        $request,
        $user
    );
    $transaction = Transaction::where('account_id', $account->id)->first();

    expect($transaction->total === 100.00)->toBeTrue();
});

test('can store deposito handle failure transactions', function (): void {
    $user = User::factory()->create();
    $account = Account::factory()->create([
        'user_id' => $user->id,
        'balance' => 1000,
        'credit_limit' => 1000,
    ])->fresh();

    $transaction = Transaction::factory()->create([
        'description' => 'Teste de Saque',
        'type' => 'deposito',
        'amount' => '100.00',
        'account_id' => $account->id,
    ]);

    $service = Mockery::mock(TransactionService::class)
        ->makePartial()
        ->shouldReceive('createSubledger')
        ->andThrow(new \Exception('Simulando falha no subledger'))
        ->getMock();

    $service->process($transaction);

    $account = $account->fresh();
    expect($account->balance)->toBe(1000.0);
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
        route('transactions.store'),
        Response::HTTP_UNPROCESSABLE_ENTITY,
        $request,
        $user
    );
});
