<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'value',
        'ledger_id',
        'transaction_id',
    ];

    public function ledger(): BelongsTo
    {
        return $this->belongsTo(Ledger::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
