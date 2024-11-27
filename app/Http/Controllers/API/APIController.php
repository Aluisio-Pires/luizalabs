<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class APIController
{
    protected function response(array $data, $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'data' => $data,
        ], $status);
    }

    protected function error(array $errors = [], string $message = 'Falha na requisição', $status = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
