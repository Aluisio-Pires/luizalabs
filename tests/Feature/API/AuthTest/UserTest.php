<?php

use Symfony\Component\HttpFoundation\Response;

test('can user see own data', function (): void {
    $this->simpleTest(
        'post',
        route('api.v1.auth.user'),
        Response::HTTP_OK,
    );
});
