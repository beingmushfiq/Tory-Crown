<?php

namespace App\Services;

use App\Models\Coupon;
use Carbon\Carbon;

class CouponService
{
    public function validateAndApply($code, $subtotal)
    {
        $coupon = Coupon::where('code', $code)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', Carbon::now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', Carbon::now());
            })
            ->first();

        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid or expired coupon.'];
        }

        // Check usage limit
        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            return ['valid' => false, 'message' => 'This coupon has reached its usage limit.'];
        }

        if ($subtotal < $coupon->min_order_amount) {
            return [
                'valid' => false, 
                'message' => "Minimum order amount of ৳{$coupon->min_order_amount} required."
            ];
        }

        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = ($subtotal * $coupon->value) / 100;
        } else {
            // Fixed amount discount cannot exceed subtotal
            $discount = min($coupon->value, $subtotal);
        }

        return [
            'valid' => true,
            'discount' => round($discount, 2),
            'coupon_id' => $coupon->id,
            'message' => 'Coupon applied successfully!'
        ];
    }

    public function incrementUsage(Coupon $coupon)
    {
        $coupon->increment('used_count');
    }
}
