<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'identify_type',
        'identity_number',
        'address',
        'city',
        'province',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
