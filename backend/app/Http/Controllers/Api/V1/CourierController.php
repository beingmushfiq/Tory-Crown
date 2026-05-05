<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Shipment;
use App\Models\Order;

class CourierController extends Controller
{
    public function webhookSteadfast(Request $request)
    {
        // Signature verification (Phase 10 Security Hardening)
        $signature = $request->header('X-Steadfast-Signature');
        $expectedSignature = hash_hmac('sha256', $request->getContent(), config('courier.steadfast_secret', 'mock-secret'));

        if (!hash_equals($expectedSignature, $signature ?? '')) {
            Log::warning('Steadfast Webhook invalid signature', ['ip' => $request->ip()]);
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        Log::info('Steadfast Webhook', $request->all());

        $consignmentId = $request->input('consignment_id');
        $status = $request->input('status'); // e.g., 'delivered', 'in_transit'

        if ($consignmentId && $status) {
            $shipment = Shipment::where('consignment_id', $consignmentId)->first();
            if ($shipment) {
                $shipment->update([
                    'status' => $status,
                    'webhook_data' => json_encode($request->all())
                ]);

                // Update Order timeline if needed
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function webhookPathao(Request $request)
    {
        Log::info('Pathao Webhook', $request->all());
        return response()->json(['status' => 'success']);
    }
}
