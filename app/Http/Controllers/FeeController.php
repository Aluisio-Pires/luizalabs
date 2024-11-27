<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Models\Fee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\Response;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): InertiaResponse
    {
        Gate::authorize('viewAny', Fee::class);
        $fees = Fee::with('transactionType')->orderBy('created_at', 'desc')->paginate(3);

        return Inertia::render('Fee/Index', [
            'fees' => Inertia::merge(fn () => $fees->items()),
            'currentPage' => $fees->currentPage(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): InertiaResponse
    {
        Gate::authorize('create', Fee::class);

        return Inertia::render('Fee/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeRequest $request): RedirectResponse
    {
        Gate::authorize('create', Fee::class);

        Fee::create($request->validated());

        return redirect(route('fees.index'), Response::HTTP_CREATED);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fee $fee): InertiaResponse
    {
        Gate::authorize('update', $fee);

        return Inertia::render('Fee/Edit', [
            'fee' => $fee->load(['transactionType']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeRequest $request, Fee $fee): RedirectResponse
    {
        Gate::authorize('update', $fee);

        $fee->update($request->validated());

        return redirect(route('fees.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fee $fee): RedirectResponse
    {
        Gate::authorize('delete', $fee);

        $fee->delete();

        return redirect(route('fees.index'));
    }
}
