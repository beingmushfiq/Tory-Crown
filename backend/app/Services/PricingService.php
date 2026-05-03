<?php

namespace App\Services;

use App\Models\GoldRate;
use App\Models\ProductVariant;
use App\Models\Product;

class PricingService
{
    public function calculateVariantPrice(ProductVariant $variant)
    {
        $goldRate = GoldRate::where('karat', $variant->karat)
            ->orderBy('effective_date', 'desc')
            ->first();

        if (!$goldRate) {
            return 0;
        }

        $basePrice = ($goldRate->price_per_gram * $variant->weight_in_grams) + $variant->making_charge;
        
        $vatPercentage = $variant->product->vat_percentage ?? 5.00;
        $vatAmount = ($basePrice * $vatPercentage) / 100;

        return [
            'base_price' => round($basePrice, 2),
            'vat_amount' => round($vatAmount, 2),
            'total_price' => round($basePrice + $vatAmount, 2),
            'gold_rate' => $goldRate->price_per_gram,
            'weight' => $variant->weight_in_grams,
            'making_charge' => $variant->making_charge,
            'karat' => $variant->karat,
        ];
    }
}
