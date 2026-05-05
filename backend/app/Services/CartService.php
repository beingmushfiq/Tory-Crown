<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartService
{
    protected Cart $cart;

    public function __construct()
    {
        $this->cart = $this->resolveCart();
    }

    /** Get or create a cart for the current user or session. */
    protected function resolveCart(): Cart
    {
        $userId    = Auth::id();
        $sessionId = session()->getId();

        if ($userId) {
            $cart = Cart::firstOrCreate(['user_id' => $userId]);
            // Merge guest cart if exists
            $guestCart = Cart::where('session_id', $sessionId)->where('user_id', null)->first();
            if ($guestCart) {
                $this->mergeCart($guestCart, $cart);
            }
            return $cart;
        }

        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    public function get(): Cart
    {
        return $this->cart->load('items.product', 'items.variant');
    }

    public function add(int $productId, ?int $variantId, int $qty = 1): CartItem
    {
        $variant = $variantId ? ProductVariant::findOrFail($variantId) : null;
        $price   = $variant?->computed_price ?? 0;

        $item = $this->cart->items()
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        if ($item) {
            $item->increment('qty', $qty);
            $item->update(['price_snapshot' => $price]);
        } else {
            $item = $this->cart->items()->create([
                'product_id'     => $productId,
                'variant_id'     => $variantId,
                'qty'            => $qty,
                'price_snapshot' => $price,
            ]);
        }

        return $item->fresh();
    }

    public function updateQty(int $itemId, int $qty): bool
    {
        $item = $this->cart->items()->findOrFail($itemId);
        if ($qty <= 0) {
            $item->delete();
            return true;
        }
        return (bool) $item->update(['qty' => $qty]);
    }

    public function remove(int $itemId): bool
    {
        return (bool) $this->cart->items()->findOrFail($itemId)->delete();
    }

    public function applyCoupon(string $code): array
    {
        $coupon = Coupon::where('code', strtoupper($code))->where('is_active', true)->first();

        if (! $coupon) {
            return ['success' => false, 'error' => 'INVALID_COUPON'];
        }

        $subtotal = $this->subtotal();

        if (! $coupon->isValid($subtotal)) {
            return ['success' => false, 'error' => 'COUPON_NOT_APPLICABLE'];
        }

        $discount = $coupon->calculateDiscount($subtotal);
        $this->cart->update([
            'coupon_code'     => $coupon->code,
            'coupon_discount' => $discount,
        ]);

        return ['success' => true, 'discount' => $discount, 'coupon' => $coupon];
    }

    public function removeCoupon(): void
    {
        $this->cart->update(['coupon_code' => null, 'coupon_discount' => 0]);
    }

    public function subtotal(): float
    {
        return $this->cart->items->sum(fn($i) => $i->price_snapshot * $i->qty);
    }

    public function total(): float
    {
        return max(0, $this->subtotal() - ($this->cart->coupon_discount ?? 0));
    }

    protected function mergeCart(Cart $source, Cart $target): void
    {
        foreach ($source->items as $item) {
            $this->add($item->product_id, $item->variant_id, $item->qty);
        }
        $source->delete();
    }

    public function clear(): void
    {
        $this->cart->items()->delete();
        $this->cart->update(['coupon_code' => null, 'coupon_discount' => 0]);
    }
}
