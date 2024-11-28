<?php

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

pest()->group('web', 'account');

test('can create accounts', function (): void {
    $user = User::factory()->create();
    $request = [
        'user_id' => $user->id,
        'balance' => '1000.00',
        'credit_limit' => '1000.00',
    ];

    $this->authRequest('post',
        route('accounts.store'),
        Response::HTTP_FOUND,
        $request,
        $user
    );
});
