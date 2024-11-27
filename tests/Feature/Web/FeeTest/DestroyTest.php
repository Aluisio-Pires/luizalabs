<?php

use App\Models\Fee;
use Symfony\Component\HttpFoundation\Response;

test('can destroy a fee', function (): void {
    $fee = Fee::factory()->create();

    $this->authRequest('delete',
        route('fees.destroy', ['fee' => $fee->id]),
        Response::HTTP_FOUND,
    );
});
