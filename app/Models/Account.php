<?php

namespace App\Models;

use App\Casts\Micron;
use App\Observers\AccountObserver;
use Database\Factories\AccountFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(AccountObserver::class)]
class Account extends Model
{
    /** @use HasFactory<AccountFactory> */
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

    /**
     * @return BelongsTo<User,$this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<Transaction,$this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return HasMany<Transaction,$this>
     */
    public function inflows(): HasMany
    {
        return $this->hasMany(Transaction::class, 'payee_id');
    }

    /**
     * @return HasMany<Subledger,$this>
     */
    public function subledgers(): HasMany
    {
        return $this->hasMany(Subledger::class, 'account_id');
    }

    /**
     * @return MorphMany<Trail,$this>
     */
    public function trails(): MorphMany
    {
        return $this->morphMany(Trail::class, 'trailable');
    }
}
