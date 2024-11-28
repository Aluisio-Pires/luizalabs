<?php

use App\Models\Fee;
use Symfony\Component\HttpFoundation\Response;

pest()->group('api', 'fee');

test('can destroy a fee', function (): void {
    $fee = Fee::factory()->create();

    $this->authRequest('delete',
        route('api.v1.fees.destroy', ['fee' => $fee->id]),
        Response::HTTP_NO_CONTENT,
    );
});
