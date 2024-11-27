<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Models\Fee;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function create()
    {
        Gate::authorize('create', Fee::class);

        return Inertia::render('Fee/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeRequest $request)
    {
        Gate::authorize('create', Fee::class);

        $transactionType = TransactionType::where('slug', $request->transaction_type_name)->first();
        Fee::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'transaction_type_id' => $transactionType->getKey(),
        ]);

        return redirect(route('fees.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fee $fee)
    {
        Gate::authorize('update', $fee);

        return Inertia::render('Fee/Edit', [
            'fee' => $fee->load(['transactionType']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeRequest $request, Fee $fee)
    {
        Gate::authorize('update', $fee);

        $transactionType = TransactionType::where('slug', $request->transaction_type_name)->first();
        $fee->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'transaction_type_id' => $transactionType->getKey(),
        ]);

        return redirect(route('fees.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fee $fee)
    {
        Gate::authorize('delete', $fee);

        $fee->delete();

        return redirect(route('fees.index'));
    }
}
