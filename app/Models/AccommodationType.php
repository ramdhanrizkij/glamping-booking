<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccommodationType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'capacity',
        'max_capacity',
        'bed_info',
        'size_info',
        'base_price',
        'extra_guest_price',
        'main_image',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    public function accommodationUnits(): HasMany
    {
        return $this->hasMany(AccommodationUnit::class);
    }
}
