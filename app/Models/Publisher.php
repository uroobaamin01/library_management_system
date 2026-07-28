<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publisher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug', // <-- Make sure slug is here
        'email',
        'phone',
        'address',
        'status',
        'created_by',
        'updated_by',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}