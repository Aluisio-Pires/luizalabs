<?php

namespace App\Models;

use App\Casts\Micron;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'fee',
        'ledger_id',
        'transaction_id',
        'account_id',
    ];

    protected $casts = [
        'value' => Micron::class,
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function formattedCreatedAt(): Attribute
    {
        return new Attribute(
            get: fn () => $this->created_at ? $this->created_at->format('d/m/Y H:i') : null
        );
    }

    public function ledger(): BelongsTo
    {
        return $this->belongsTo(Ledger::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
