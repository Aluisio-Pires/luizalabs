<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'value',
        'transaction_type_id',
    ];

    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }
}
