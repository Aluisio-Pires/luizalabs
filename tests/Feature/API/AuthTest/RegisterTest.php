<?php

use Symfony\Component\HttpFoundation\Response;

test('can user register', function (): void {
    $request = [
        'email' => fake()->email,
        'name' => fake()->name,
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $this->simpleRequest(
        'post',
        route('api.v1.auth.register'),
        Response::HTTP_CREATED,
        $request
    );
});
