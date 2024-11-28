<?php

namespace App\Models;

use Database\Factories\TransactionTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionType extends Model
{
    /** @use HasFactory<TransactionTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * @return HasMany<Transaction,$this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return HasMany<Fee,$this>
     */
    public function fees(): HasMany
    {
        return $this->hasMany(Fee::class);
    }
}
