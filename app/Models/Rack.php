<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rack extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'capacity',
        'status',
    ];

    // Local scope for active racks
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function shelves(): HasMany
    {
        return $this->hasMany(Shelf::class);
    }
}