<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
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

    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function payee(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'payee_id');
    }

    public function subledgers(): HasMany
    {
        return $this->hasMany(Subledger::class);
    }
}
