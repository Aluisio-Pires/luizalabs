<?php

use Symfony\Component\HttpFoundation\Response;

test('can user logout', function (): void {
    $this->authRequest(
        'post',
        route('api.auth.logout'),
        Response::HTTP_OK,
    );
});
