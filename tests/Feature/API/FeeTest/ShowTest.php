<?php

use App\Models\Fee;
use Symfony\Component\HttpFoundation\Response;

pest()->group('api', 'fee');

test('can show a fee', function (): void {
    $fee = Fee::factory()->create();

    $this->authRequest('get',
        route('api.v1.fees.show', ['fee' => $fee->id]),
        Response::HTTP_OK,
    );
});
