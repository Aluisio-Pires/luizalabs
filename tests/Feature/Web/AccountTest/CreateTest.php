<?php

use Symfony\Component\HttpFoundation\Response;

test('can create accounts', function (): void {
    $this->authRequest('get',
        route('accounts.create'),
        Response::HTTP_OK,
    );
});
