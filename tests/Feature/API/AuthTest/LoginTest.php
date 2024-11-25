<?php

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

test('can user login', function (): void {
    $user = User::factory()->create();
    $request = [
        'email' => $user->email,
        'password' => 'password',
    ];

    $this->simpleRequest(
        'post',
        route('api.auth.login'),
        Response::HTTP_OK,
        $request
    );
});

test('can user fail login with wrong credentials', function (): void {
    $user = User::factory()->create();
    $request = [
        'email' => $user->email,
        'password' => 'password1',
    ];

    $this->simpleRequest(
        'post',
        route('api.auth.login'),
        Response::HTTP_UNPROCESSABLE_ENTITY,
        $request
    );
});
