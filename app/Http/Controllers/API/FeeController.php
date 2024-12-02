<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Models\Fee;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class FeeController extends APIController
{
    /**
     * Recupera uma lista paginada de Taxas.
     *
     * @Request({
     *        tags: Taxa
     *   })
     */
    public function index(): JsonResponse
    {
        Gate::authorize('viewAny', Fee::class);

        $fees = Fee::query()
            ->paginate(20);

        return response()->json($fees);
    }

    /**
     * Cria uma nova Taxa.
     *
     * @Request({
     *         tags: Taxa
     *    })
     */
    public function store(StoreFeeRequest $request): JsonResponse
    {
        Gate::authorize('create', Fee::class);

        $fee = Fee::create($request->validated());

        return $this->response([
            'account' => $fee,
        ], Response::HTTP_CREATED);
    }

    /**
     * Recupera os dados de uma Taxa específica.
     *
     * @Request({
     *         tags: Taxa
     *    })
     */
    public function show(Fee $fee): JsonResponse
    {
        Gate::authorize('view', $fee);

        return $this->response(['account' => $fee]);
    }

    /**
     * Atualiza os dados de uma Taxa específica.
     *
     * @Request({
     *         tags: Taxa
     *    })
     */
    public function update(UpdateFeeRequest $request, Fee $fee): JsonResponse
    {
        Gate::authorize('update', $fee);

        $fee->update($request->validated());

        return $this->response(['account' => $fee]);
    }

    /**
     * Remove uma Taxa específica.
     *
     * @Request({
     *         tags: Taxa
     *    })
     */
    public function destroy(Fee $fee): JsonResponse
    {
        Gate::authorize('delete', $fee);

        $fee->delete();

        return $this->response(['message' => 'Taxa deletada com sucesso'], Response::HTTP_NO_CONTENT);
    }
}
