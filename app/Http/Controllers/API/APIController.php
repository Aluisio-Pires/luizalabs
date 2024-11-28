<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class APIController
{
    /**
     * @param  array<string, mixed>  $data
     */
    protected function response(array $data, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'data' => $data,
        ], $status);
    }

    /**
     * @param  array<string, mixed>  $errors
     */
    protected function error(array $errors = [], string $message = 'Falha na requisição', int $status = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
