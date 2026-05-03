<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\GoldRate;
use App\Services\PricingService;
use App\Services\PaymentService;
use App\Services\AnalyticsService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    protected $pricingService;
    protected $paymentService;
    protected $analyticsService;
    protected $smsService;

    public function __construct(
        PricingService $pricingService,
        PaymentService $paymentService,
        AnalyticsService $analyticsService,
        SmsService $smsService
    ) {
        $this->pricingService = $pricingService;
        $this->paymentService = $paymentService;
        $this->analyticsService = $analyticsService;
        $this->smsService = $smsService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'shipping_address' => 'required|string',
            'city' => 'required|string',
            'payment_method' => 'required|string',
            'items' => 'required|array',
            'items.*.variant_id' => 'required|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $orderNumber = 'TC-' . strtoupper(Str::random(8));
            $subtotal = 0;
            $vatTotal = 0;
            $itemsToCreate = [];

            foreach ($validated['items'] as $itemData) {
                $variant = ProductVariant::with('product')->find($itemData['variant_id']);
                $pricing = $this->pricingService->calculateVariantPrice($variant);

                $subtotal += $pricing['base_price'] * $itemData['quantity'];
                $vatTotal += $pricing['vat_amount'] * $itemData['quantity'];

                $itemsToCreate[] = [
                    'product_id' => $variant->product_id,
                    'variant_id' => $variant->id,
                    'product_name' => $variant->product->name,
                    'variant_sku' => $variant->sku,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $pricing['total_price'],
                    'weight' => $variant->weight_in_grams,
                    'gold_rate_at_purchase' => $pricing['gold_rate'],
                ];
            }

            $shippingCharge = $validated['city'] === 'Dhaka' ? 80 : 150;
            $grandTotal = $subtotal + $vatTotal + $shippingCharge;
            
            // Partial advance logic if needed
            $partialAdvance = 0;
            if ($validated['payment_method'] === 'cod' && $grandTotal > 50000) {
                 // Example: Force partial advance for high value COD
                 // $partialAdvance = 500; 
            }

            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'city' => $validated['city'],
                'subtotal' => $subtotal,
                'vat_total' => $vatTotal,
                'shipping_charge' => $shippingCharge,
                'grand_total' => $grandTotal,
                'partial_advance' => $partialAdvance,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'event_id' => Str::uuid(),
            ]);

            foreach ($itemsToCreate as $item) {
                $order->items()->create($item);
            }

            // Send CAPI Purchase Event
            $this->analyticsService->sendCapiEvent(
                'Purchase',
                [
                    'em' => $order->customer_email,
                    'ph' => $order->customer_phone,
                    'fn' => $order->customer_name,
                ],
                [
                    'value' => $order->grand_total,
                    'currency' => 'BDT',
                    'content_ids' => $order->items->pluck('variant_sku')->toArray(),
                    'content_type' => 'product',
                ],
                $order->event_id
            );

            // Send SMS Notification
            $this->smsService->sendSms(
                $order->customer_phone,
                "Tory Crown: Your order #{$order->order_number} has been placed. Total: BDT {$order->grand_total}. Thank you!"
            );

            // Initiate Payment Redirect
            $paymentResult = $this->paymentService->initiatePayment($order, $validated['payment_method']);

            return response()->json([
                'success' => true,
                'order_number' => $order->order_number,
                'payment_result' => $paymentResult,
            ]);
        });
    }
}
