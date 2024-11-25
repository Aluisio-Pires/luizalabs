<?php

namespace App\Http\Services;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\TransactionType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    public function create(array $request): ?Transaction
    {
        try {
            return DB::transaction(function () use ($request): Transaction {
                return $this->createTransaction($request);
            });
        } catch (Exception $e) {
            Log::error($e);

            return null;
        }
    }

    private function createTransaction(array $request): Transaction
    {
        $transactionType = $this->findTransactionType($request['type']);
        $fee = $this->calculateFee($request['amount'], $transactionType);
        $total = $fee + $request['amount'];

        return Transaction::create([
            'description' => $request['description'],
            'type' => $request['type'],
            'status' => 'pendente',
            'message' => null,
            'amount' => $request['amount'],
            'fee' => $fee,
            'total' => $total,
            'transaction_type_id' => $transactionType->getKey(),
            'account_id' => $this->findAccount($request['account_number'])->getKey(),
            'payee_id' => $request['payee_number'] ? $this->findAccount($request['payee_number'])->getKey() : null,
        ]);
    }

    private function findTransactionType(string $type): TransactionType
    {
        return TransactionType::where('slug', $type)->firstOrFail();
    }

    private function findAccount(int|string $accountNumber): Account
    {
        return Account::where('number', $accountNumber)->first();
    }

    private function calculateFee(int $amount, TransactionType $transactionType): int
    {
        $total = 0;
        $fees = $transactionType->fees()->get();

        foreach ($fees as $fee) {
            if ($fee->type === 'percentage') {
                $total += $amount * ($fee->value / 100);
            } else {
                $total += $fee->value;
            }
        }

        return $total;
    }
}
