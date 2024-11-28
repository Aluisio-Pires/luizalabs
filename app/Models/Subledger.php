<?php

namespace App\Models;

use App\Casts\Micron;
use Database\Factories\SubledgerFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subledger extends Model
{
    /** @use HasFactory<SubledgerFactory> */
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

    /**
     * @phpstan-param model-property<Attribute> $formatted_created_at
     */
    protected $appends = [
        'formatted_created_at',
    ];

    /**
     * @return Attribute<string|null, never>
     */
    public function formattedCreatedAt(): Attribute
    {
        return new Attribute(
            get: fn () => $this->created_at ? $this->created_at->format('d/m/Y H:i') : null
        );
    }

    /**
     * @return BelongsTo<Ledger,$this>
     */
    public function ledger(): BelongsTo
    {
        return $this->belongsTo(Ledger::class);
    }

    /**
     * @return BelongsTo<Transaction,$this>
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * @return BelongsTo<Account,$this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
