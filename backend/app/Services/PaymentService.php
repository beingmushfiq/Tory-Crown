<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function initiatePayment(Order $order, $method)
    {
        switch ($method) {
            case 'bkash':
                return $this->initiateBkash($order);
            case 'nagad':
                return $this->initiateNagad($order);
            case 'sslcommerz':
                return $this->initiateSSLCommerz($order);
            case 'cod':
                return ['status' => 'success', 'redirect_url' => '/order-success/' . $order->order_number];
            default:
                throw new \Exception("Invalid payment method");
        }
    }

    protected function initiateBkash(Order $order)
    {
        // Mocking bKash redirection for now
        Log::info("Initiating bKash for Order: " . $order->order_number);
        return ['status' => 'redirect', 'redirect_url' => 'https://sandbox.checkout.pay.bKash.com/...'];
    }

    protected function initiateNagad(Order $order)
    {
        Log::info("Initiating Nagad for Order: " . $order->order_number);
        return ['status' => 'redirect', 'redirect_url' => 'https://sandbox.mynagad.com/...'];
    }

    protected function initiateSSLCommerz(Order $order)
    {
        Log::info("Initiating SSLCommerz for Order: " . $order->order_number);
        return ['status' => 'redirect', 'redirect_url' => 'https://sandbox.sslcommerz.com/...'];
    }
}
