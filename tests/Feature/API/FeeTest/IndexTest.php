<?php

use App\Models\Fee;
use Symfony\Component\HttpFoundation\Response;

pest()->group('api', 'fee');

test('can index fees', function (): void {
    Fee::factory()->count(3)->create();
    $response = $this->authRequest('get',
        route('api.v1.fees.index'),
        Response::HTTP_OK,
    );

    $response->assertJsonCount(3, 'data');
});
