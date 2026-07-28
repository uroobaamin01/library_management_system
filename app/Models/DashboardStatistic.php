<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardStatistic extends Model
{
    protected $fillable = [
        'metric_key',
        'metric_value',
        'last_calculated_at',
    ];

    protected $casts = [
        'metric_value' => 'integer',
        'last_calculated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function updateMetric(string $key, int $value): self
    {
        return static::updateOrCreate(
            ['metric_key' => $key],
            [
                'metric_value' => $value,
                'last_calculated_at' => now(),
            ]
        );
    }
}