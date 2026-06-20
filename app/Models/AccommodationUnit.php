<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccommodationUnit extends Model
{
    protected $fillable = [
        'accommodation_type_id',
        'unit_code',
        'name',
        'description',
        'status',
        'is_active',
    ];

    public function accommodationType(): BelongsTo
    {
        return $this->belongsTo(AccommodationType::class);
    }
}
