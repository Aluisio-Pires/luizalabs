<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\IndexTrailRequest;
use App\Models\Account;
use App\Models\Trail;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class TrailController extends APIController
{
    /**
     * Recupera uma lista paginada de trails.
     *
     * @Request({
     *       tags: Trail
     *  })
     */
    public function index(IndexTrailRequest $request): JsonResponse
    {
        Gate::authorize('viewAny', Trail::class);

        $trails = Trail::with('trailable')
            ->where('user_id', auth()->user()->id)
            ->when($request->action, function ($query) {
                return $query->where('action', request('action'));
            })
            ->when($request->relation_name, function ($query) {
                $model = request('relation_name') === 'accounts' ? Account::class : Transaction::class;

                return $query->where('trailable_type', $model);
            })
            ->when($request->relation_id, function ($query) {
                return $query->where('trailable_id', request('relation_id'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return $this->response(['trails' => $trails]);
    }

    /**
     * Exibe uma trail em específica.
     *
     * @Request({
     *       tags: Trail
     *  })
     */
    public function show(Trail $trail): JsonResponse
    {
        $trail->load('trailable');

        return $this->response(['trail' => $trail]);
    }
}
