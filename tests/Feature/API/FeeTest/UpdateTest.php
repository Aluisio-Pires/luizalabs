<?php

use App\Models\Fee;
use Symfony\Component\HttpFoundation\Response;

pest()->group('api', 'fee');

test('can update a fee', function (): void {
    $fee = Fee::factory()->create();

    $request = [
        'name' => 'Test Fee',
        'description' => 'Test Fee Description',
        'transaction_type_name' => 'saque',
    ];

    $this->authRequest('put',
        route('api.v1.fees.update', ['fee' => $fee->id]),
        Response::HTTP_OK,
        $request
    );
});
