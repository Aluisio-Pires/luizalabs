<?php

namespace App\Models;

use App\Casts\Micron;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'value',
        'ledger_id',
        'transaction_id',
    ];

    protected $casts = [
        'value' => Micron::class,
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
