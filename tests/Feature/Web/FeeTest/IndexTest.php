<?php

use App\Models\Fee;
use Symfony\Component\HttpFoundation\Response;

test('can index fees', function (): void {
    Fee::factory()->count(3)->create();
    $response = $this->authRequest('get',
        route('fees.index'),
        Response::HTTP_OK,
    );
});
