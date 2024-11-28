<?php

namespace App\Models;

use Database\Factories\TrailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Trail extends Model
{
    /** @use HasFactory<TrailFactory> */
    use HasFactory;

    protected $fillable = [
        'action',
        'trailable_type',
        'trailable_id',
        'before',
        'after',
        'user_id',
    ];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
    ];

    /**
     * @return MorphTo<Model, $this>
     */
    public function trailable(): MorphTo
    {
        return $this->morphTo();
    }
}
