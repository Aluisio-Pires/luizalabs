<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Models\Fee;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class FeeController extends APIController
{
    /**
     * Recupera uma lista paginada de Taxas.
     */
    public function index()
    {
        Gate::authorize('viewAny', Fee::class);

        $fees = Fee::query()
            ->paginate(20);

        return response()->json($fees);
    }

    /**
     * Cria uma nova Taxa.
     */
    public function store(StoreFeeRequest $request)
    {
        Gate::authorize('create', Fee::class);
        $fee = Fee::create($request->validated());

        return response()->json([
            'message' => 'Conta criada com sucesso',
            'account' => $fee,
        ], Response::HTTP_CREATED);
    }

    /**
     * Recupera os dados de uma Taxa específica.
     */
    public function show(Fee $fee)
    {
        Gate::authorize('view', $fee);

        return $this->response(['account' => $fee]);
    }

    /**
     * Atualiza os dados de uma Taxa específica.
     */
    public function update(UpdateFeeRequest $request, Fee $fee)
    {
        Gate::authorize('update', $fee);

        $fee->update($request->validated());

        return $this->response(['account' => $fee]);
    }

    /**
     * Remove uma Taxa específica.
     */
    public function destroy(Fee $fee)
    {
        Gate::authorize('delete', $fee);

        $fee->delete();

        return $this->response(['message' => 'Taxa deletada com sucesso'], Response::HTTP_NO_CONTENT);
    }
}
