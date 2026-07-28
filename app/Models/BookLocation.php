<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookLocation extends Model
{
    protected $fillable = [
        'rack_id',
        'shelf_id',
        'location_code',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function rack(): BelongsTo
    {
        return $this->belongsTo(Rack::class);
    }

    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class);
    }

    public function copies(): HasMany
    {
        return $this->hasMany(BookCopy::class, 'location_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}