<?php

use Symfony\Component\HttpFoundation\Response;

pest()->group('web', 'account');

test('can create accounts', function (): void {
    $this->authRequest('get',
        route('accounts.create'),
        Response::HTTP_OK,
    );
});
