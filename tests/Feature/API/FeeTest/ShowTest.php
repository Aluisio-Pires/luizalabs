<?php

use App\Models\Fee;
use Symfony\Component\HttpFoundation\Response;

test('can show a fee', function (): void {
    $fee = Fee::factory()->create();

    $this->authRequest('get',
        route('api.fees.show', ['fee' => $fee->id]),
        Response::HTTP_OK,
    );
});
