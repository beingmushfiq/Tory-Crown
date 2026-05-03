<?php

namespace App\Services;

use App\Models\Order;
use App\Models\CourierLog;
use Illuminate\Support\Facades\Http;

class CourierService
{
    protected $baseUrl;
    protected $apiKey;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('services.steadfast.base_url', 'https://portal.steadfast.com.bd/api/v1');
        $this->apiKey = config('services.steadfast.api_key');
        $this->secretKey = config('services.steadfast.secret_key');
    }

    public function createSteadfastOrder(Order $order)
    {
        $payload = [
            'invoice' => $order->order_number,
            'recipient_name' => $order->customer_name,
            'recipient_phone' => $order->customer_phone,
            'recipient_address' => $order->shipping_address,
            'cod_amount' => $order->grand_total - $order->partial_advance,
            'note' => 'Luxury Jewelry - Handle with care',
        ];

        try {
            $response = Http::withHeaders([
                'Api-Key' => $this->apiKey,
                'Secret-Key' => $this->secretKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/create_order', $payload);

            $data = $response->json();
            $isSuccess = $response->successful() && ($data['status'] ?? null) == 200;

            CourierLog::create([
                'order_id' => $order->id,
                'courier_name' => 'Steadfast',
                'action' => 'create_order',
                'request_payload' => $payload,
                'response_payload' => $data,
                'is_success' => $isSuccess,
            ]);

            if ($isSuccess) {
                $order->update([
                    'consignment_id' => $data['order']['consignment_id'] ?? null,
                    'tracking_url' => $data['order']['tracking_code'] ?? null,
                    'courier_status' => 'pending',
                ]);
                return ['success' => true, 'message' => 'Order created in Steadfast.'];
            }

            return ['success' => false, 'message' => $data['errors'] ?? $data['message'] ?? 'Failed to create order in Steadfast.'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection error: ' . $e->getMessage()];
        }
    }

    public function checkSteadfastStatus(Order $order)
    {
        if (!$order->consignment_id) {
            return ['success' => false, 'message' => 'No consignment ID found.'];
        }

        try {
            $response = Http::withHeaders([
                'Api-Key' => $this->apiKey,
                'Secret-Key' => $this->secretKey,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . '/status_by_cid/' . $order->consignment_id);

            $data = $response->json();
            $isSuccess = $response->successful() && ($data['status'] ?? null) == 200;

            if ($isSuccess) {
                $status = $data['delivery_status'] ?? 'unknown';
                $order->update(['courier_status' => $status]);
                return ['success' => true, 'status' => $status, 'message' => 'Status updated to: ' . $status];
            }

            return ['success' => false, 'message' => 'Failed to fetch status.'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection error: ' . $e->getMessage()];
        }
    }
}
