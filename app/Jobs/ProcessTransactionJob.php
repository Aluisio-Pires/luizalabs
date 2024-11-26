<?php

namespace App\Jobs;

use App\Http\Services\TransactionService;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Throwable;

class ProcessTransactionJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Transaction $transaction)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $lock1 = Cache::lock("lock:transaction:account_id:{$this->transaction->account_id}", 10);
        $lock2 = Cache::lock("lock:transaction:account_id:{$this->transaction->payee_id}", 10);

        if ($lock1->get() && $lock2->get()) {
            try {
                (new TransactionService)->process($this->transaction);
            } finally {
                $lock1->release();
                $lock2->release();
            }
        } else {
            $this->release(2);
        }
    }

    public function failed(?Throwable $exception): void
    {
        $this->transaction->update([
            'status' => 'falha',
            'message' => 'A transação falhou. Tente novamente mais tarde.',
        ]);
    }
}
