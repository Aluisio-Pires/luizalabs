<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UpdateSubledgerRequest;
use App\Models\Subledger;
use Illuminate\Support\Facades\Gate;

class SubledgerController extends APIController
{
    /**
     * Recupera uma lista paginada de Subledgers.
     *
     * @Request({
     *         tags: Subledger
     *    })
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
     *
     * @Request({
     *          tags: Subledger
     *     })
     */
    public function show(Subledger $subledger)
    {
        Gate::authorize('view', $subledger);

        return $this->response(['subledger' => $subledger]);
    }

    /**
     * Atualiza os dados de uma Subledger específico.
     *
     * @Request({
     *          tags: Subledger
     *     })
     */
    public function update(UpdateSubledgerRequest $request, Subledger $subledger)
    {
        Gate::authorize('update', $subledger);

        $subledger->update($request->validated());

        return $this->response(['subledger' => $subledger]);
    }
}
