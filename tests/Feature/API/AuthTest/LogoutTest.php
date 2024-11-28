<?php

use Symfony\Component\HttpFoundation\Response;

pest()->group('api', 'auth');

test('can user logout', function (): void {
    $this->authRequest(
        'post',
        route('api.v1.auth.logout'),
        Response::HTTP_OK,
    );
});
