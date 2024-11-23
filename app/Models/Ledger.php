<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function subledgers(): HasMany
    {
        return $this->hasMany(Subledger::class);
    }
}
