<?php

use App\Models\Fee;
use Symfony\Component\HttpFoundation\Response;

pest()->group('web', 'fee');

test('can edit fees', function (): void {
    $fee = Fee::factory()->create();

    $this->authRequest('get',
        route('fees.edit', ['fee' => $fee->id]),
        Response::HTTP_OK,
    );
});
