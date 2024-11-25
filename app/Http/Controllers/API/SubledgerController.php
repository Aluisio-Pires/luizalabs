<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UpdateSubledgerRequest;
use App\Models\Subledger;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class SubledgerController extends APIController
{
    /**
     * Recupera uma lista paginada de Subledgers.
     */
    public function index()
    {
        Gate::authorize('viewAny', Subledger::class);

        $subledgers = Subledger::query()
            ->whereHas('account', fn ($query) => $query->where('user_id', auth()->user()->id))
            ->paginate(20);

        return response()->json($subledgers);
    }

    /**
     * Recupera os dados de uma Subledger específico.
     */
    public function show(Subledger $subledger)
    {
        Gate::authorize('view', $subledger);

        return $this->response(['subledger' => $subledger]);
    }

    /**
     * Atualiza os dados de uma Subledger específico.
     */
    public function update(UpdateSubledgerRequest $request, Subledger $subledger)
    {
        Gate::authorize('update', $subledger);

        $subledger->update($request->validated());

        return $this->response(['subledger' => $subledger]);
    }

    /**
     * Remove uma Subledger específico.
     */
    public function destroy(Subledger $subledger)
    {
        Gate::authorize('delete', $subledger);

        $subledger->delete();

        return $this->response(['message' => 'Subledger removido com sucesso'], Response::HTTP_NO_CONTENT);
    }
}
