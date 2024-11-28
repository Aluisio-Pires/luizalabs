<?php

use Symfony\Component\HttpFoundation\Response;

pest()->group('api', 'fee');

test('can create fees', function (): void {
    $request = [
        'name' => 'Taxa Teste',
        'description' => 'Taxa Teste Description',
        'type' => 'fixed',
        'value' => '10.00',
        'transaction_type_name' => 'saque',
    ];

    $this->authRequest('post',
        route('api.v1.fees.store'),
        Response::HTTP_CREATED,
        $request
    );
});

test('can create fees is idempotent', function (): void {
    $request = [
        'name' => 'Taxa Teste',
        'description' => 'Taxa Teste Description',
        'type' => 'fixed',
        'value' => '10.00',
        'transaction_type_name' => 'saque',
    ];

    $this->authRequest('post',
        route('api.v1.fees.store'),
        Response::HTTP_CREATED,
        $request
    );

    $this->authRequest('post',
        route('api.v1.fees.store'),
        Response::HTTP_CONFLICT,
        $request
    );
});
