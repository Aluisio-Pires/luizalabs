<?php

use App\Models\Fee;
use Symfony\Component\HttpFoundation\Response;

pest()->group('web', 'fee');

test('can index fees', function (): void {
    Fee::factory()->count(3)->create();
    $response = $this->authRequest('get',
        route('fees.index'),
        Response::HTTP_OK,
    );
});
