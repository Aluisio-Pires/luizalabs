<?php

use App\Models\TransactionType;
use Symfony\Component\HttpFoundation\Response;

test('can create fees', function (): void {
    $request = [
        'name' => 'Taxa Teste',
        'description' => 'Taxa Teste Description',
        'type' => 'fixed',
        'value' => '10.00',
        'transaction_type_id' => TransactionType::where('slug', 'deposito')->first()->id,
    ];

    $this->authRequest('post',
        route('api.fees.store'),
        Response::HTTP_CREATED,
        $request
    );
});
