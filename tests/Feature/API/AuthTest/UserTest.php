<?php

use Symfony\Component\HttpFoundation\Response;

test('can user see own data', function (): void {
    $this->simpleTest(
        'post',
        route('api.auth.user'),
        Response::HTTP_OK,
    );
});
