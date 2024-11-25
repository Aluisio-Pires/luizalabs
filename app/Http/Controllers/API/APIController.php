<?php

namespace App\Http\Controllers\API;

use Symfony\Component\HttpFoundation\Response;

abstract class APIController
{
    protected function response(array $data, $status = Response::HTTP_OK)
    {
        return response()->json([
            'data' => $data,
        ], $status);
    }

    protected function error(array $errors = [], string $message = 'Falha na requisição', $status = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
            'status' => $status,
        ]);
    }
}
