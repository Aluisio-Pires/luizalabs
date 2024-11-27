<?php

use Symfony\Component\HttpFoundation\Response;

test('can create fees', function (): void {
    $this->authRequest('get',
        route('fees.create'),
        Response::HTTP_OK,
    );
});
