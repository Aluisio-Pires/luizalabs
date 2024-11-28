<?php

namespace App\Models;

use App\Casts\Micron;
use Database\Factories\FeeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fee extends Model
{
    /** @use HasFactory<FeeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'value',
        'transaction_type_id',
    ];

    protected $casts = [
        'value' => Micron::class,
    ];

    /**
     * @return BelongsTo<TransactionType,$this>
     */
    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }
}
