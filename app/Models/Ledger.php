<?php

namespace App\Models;

use Database\Factories\LedgerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ledger extends Model
{
    /** @use HasFactory<LedgerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * @return HasMany<Subledger,$this>
     */
    public function subledgers(): HasMany
    {
        return $this->hasMany(Subledger::class);
    }
}
