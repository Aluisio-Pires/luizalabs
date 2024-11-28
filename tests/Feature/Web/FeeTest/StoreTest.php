<?php

use Symfony\Component\HttpFoundation\Response;

pest()->group('web', 'fee');

test('can store fees', function (): void {
    $request = [
        'name' => 'Taxa Teste',
        'description' => 'Taxa Teste Description',
        'type' => 'fixed',
        'value' => '10.00',
        'transaction_type_name' => 'saque',
    ];

    $this->authRequest('post',
        route('fees.store'),
        Response::HTTP_FOUND,
        $request
    );
});
