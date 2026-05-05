<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Models\ProductVariant;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $cart = $this->cartService->getCart($request->header('X-Session-ID'));
        $cart->load('items.product', 'items.variant');
        
        return response()->json([
            'success' => true,
            'data' => $cart
        ]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'qty' => 'required|integer|min:1'
        ]);

        $variant = ProductVariant::findOrFail($validated['variant_id']);

        $cart = $this->cartService->addItem(
            $request->header('X-Session-ID'),
            $variant,
            $validated['qty']
        );

        $cart->load('items.product', 'items.variant');

        return response()->json([
            'success' => true,
            'data' => $cart
        ]);
    }

    public function updateQty(Request $request, $itemId)
    {
        $validated = $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $cart = $this->cartService->updateItemQty(
            $request->header('X-Session-ID'),
            $itemId,
            $validated['qty']
        );

        $cart->load('items.product', 'items.variant');

        return response()->json([
            'success' => true,
            'data' => $cart
        ]);
    }

    public function remove(Request $request, $itemId)
    {
        $cart = $this->cartService->removeItem(
            $request->header('X-Session-ID'),
            $itemId
        );

        $cart->load('items.product', 'items.variant');

        return response()->json([
            'success' => true,
            'data' => $cart
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string'
        ]);

        // Logic to apply coupon to cart session
        // ...

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully (placeholder)'
        ]);
    }

    public function removeCoupon(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully (placeholder)'
        ]);
    }
}
