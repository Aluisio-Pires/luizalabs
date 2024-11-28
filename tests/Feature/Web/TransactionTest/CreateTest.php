<?php

use Symfony\Component\HttpFoundation\Response;

pest()->group('web', 'transaction');

test('can create transactions', function (): void {
    $this->authRequest('get',
        route('transactions.create'),
        Response::HTTP_OK,
    );
});
