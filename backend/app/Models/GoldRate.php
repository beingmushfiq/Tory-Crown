<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoldRate extends Model
{
    protected $fillable = ['karat', 'price_per_gram', 'effective_date', 'is_active', 'updated_by'];

    protected $casts = [
        'price_per_gram' => 'float',
        'effective_date' => 'date',
        'is_active'      => 'boolean',
    ];

    /**
     * Get latest active gold rate for a given karat.
     * Result is cached in Redis for 60 minutes.
     */
    public static function latestFor(string $karat): ?self
    {
        return \Cache::remember("gold_rate:{$karat}", 3600, function () use ($karat) {
            return static::where('karat', $karat)
                ->where('is_active', true)
                ->orderByDesc('effective_date')
                ->first();
        });
    }

    /** Bust cache when a new rate is saved */
    protected static function booted(): void
    {
        static::saved(function (self $rate) {
            \Cache::forget("gold_rate:{$rate->karat}");
        });
    }
}
