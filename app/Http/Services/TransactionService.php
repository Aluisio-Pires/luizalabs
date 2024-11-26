<?php

namespace App\Http\Services;

use App\Jobs\ProcessTransactionJob;
use App\Models\Account;
use App\Models\Ledger;
use App\Models\Subledger;
use App\Models\Transaction;
use App\Models\TransactionType;
use DB;
use InvalidArgumentException;
use Log;

class TransactionService
{
    public function create(array $request): ?Transaction
    {
        return $this->createTransaction($request);
    }

    private function createTransaction(array $request): Transaction
    {
        $transactionType = $this->findTransactionType($request['type']);
        $fee = $this->calculateFee($request['amount'], $transactionType);
        $total = $fee + $request['amount'];

        $transaction = Transaction::create([
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

        ProcessTransactionJob::dispatch($transaction);

        return $transaction;
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

    public function process(Transaction $transaction): array
    {
        $account = $transaction->account;

        if ($transaction->type !== 'deposito' && ! $this->hasSufficientFunds($account, $transaction->total)) {
            return $this->failTransaction($transaction, 'Saldo insuficiente para realizar essa transação.');
        }

        try {
            return DB::transaction(function () use ($transaction, $account) {
                return $this->handleTransaction($transaction, $account);
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->failTransaction($transaction, 'A transação falhou. Tente novamente mais tarde.');
        }
    }

    private function handleTransaction(Transaction $transaction, Account $account): array
    {
        return match ($transaction->type) {
            'deposito' => $this->deposit($account, $transaction),
            'saque' => $this->withdraw($account, $transaction),
            'transferencia' => $this->transfer($account, $transaction),
            default => throw new InvalidArgumentException('Tipo de transação inválido'),
        };
    }

    private function hasSufficientFunds(Account $account, float $value): bool
    {
        return $value <= $account->balance + $account->credit_limit;
    }

    private function deposit(Account $account, Transaction $transaction): array
    {
        $account->update([
            'balance' => $account->balance + $transaction->amount,
        ]);

        $this->createSubledger($transaction, $account, 'Entrada');

        return $this->completeTransaction($transaction);
    }

    private function withdraw(Account $account, Transaction $transaction): array
    {
        $account->update([
            'balance' => $account->balance - $transaction->total,
        ]);

        $this->createSubledger($transaction, $account, 'Saída');

        return $this->completeTransaction($transaction);
    }

    private function transfer(Account $account, Transaction $transaction): array
    {
        $this->withdraw($account, $transaction);

        $payee = $transaction->payee;
        $payee->update([
            'balance' => $payee->balance + $transaction->amount,
        ]);

        $this->createSubledger($transaction, $payee, 'Entrada');

        return $this->completeTransaction($transaction);
    }

    private function failTransaction(Transaction $transaction, string $message): array
    {
        $transaction->update([
            'status' => 'falha',
            'message' => 'Saldo insuficiente para realizar essa transação.',
        ]);

        return [
            'success' => false,
            'message' => 'Saldo insuficiente para realizar essa transação.',
        ];
    }

    private function completeTransaction(Transaction $transaction): array
    {
        $transaction->update([
            'status' => 'sucesso',
            'message' => 'Transação realizada com sucesso',
        ]);

        return [
            'success' => true,
            'message' => 'Transação realizada com sucesso',
        ];
    }

    private function createSubledger(Transaction $transaction, Account $account, string $tipo): void
    {
        $ledger = Ledger::where('name', $tipo)->first();

        Subledger::create([
            'value' => $tipo === 'Saída' ? $transaction->total : $transaction->amount,
            'fee' => $tipo === 'Saída' ? $transaction->fee : 0,
            'ledger_id' => $ledger->id,
            'transaction_id' => $transaction->getKey(),
            'account_id' => $account->getKey(),
        ]);
    }
}
