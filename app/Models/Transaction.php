<?php

namespace App\Models;

use App\Casts\Micron;
use App\Observers\TransactionObserver;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[ObservedBy(TransactionObserver::class)]
class Transaction extends Model
{
    /** @use HasFactory<TransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'description',
        'type',
        'status',
        'message',
        'amount',
        'fee',
        'total',
        'transaction_type_id',
        'account_id',
        'payee_id',
    ];

    protected $casts = [
        'amount' => Micron::class,
        'fee' => Micron::class,
        'total' => Micron::class,
    ];

    /**
     * @return BelongsTo<TransactionType,$this>
     */
    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }

    /**
     * @return BelongsTo<Account,$this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return BelongsTo<Account,$this>
     */
    public function payee(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'payee_id');
    }

    /**
     * @return HasMany<Subledger,$this>
     */
    public function subledgers(): HasMany
    {
        return $this->hasMany(Subledger::class);
    }

    /**
     * @return MorphMany<Trail,$this>
     */
    public function trails(): MorphMany
    {
        return $this->morphMany(Trail::class, 'trailable');
    }
}
