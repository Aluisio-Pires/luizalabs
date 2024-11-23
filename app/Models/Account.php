<?php

namespace App\Models;

use App\Casts\Micron;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'balance',
        'credit_limit',
        'user_id',
    ];

    protected $casts = [
        'balance' => Micron::class,
        'credit_limit' => Micron::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function inflows(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payee_id');
    }

    public function subledgers(): HasMany
    {
        return $this->hasMany(Subledger::class, 'account_id');
    }
}
