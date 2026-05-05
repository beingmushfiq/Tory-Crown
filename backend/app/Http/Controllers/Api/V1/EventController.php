<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\SyncEventToFacebookCAPI;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Ingest events from the frontend for server-side tracking (CAPI / GTM fallback).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string',
            'product_id' => 'nullable|integer',
            'order_id'   => 'nullable|integer',
            'payload'    => 'nullable|array',
            'source'     => 'nullable|string',
            'value'      => 'nullable|numeric',
        ]);

        $eventId = Str::uuid()->toString();
        $session = $request->header('X-Session-ID');
        $user = $request->user('sanctum');

        // Optional: Save to local database for analytics
        DB::table('events')->insert([
            'name'       => $validated['event_name'],
            'user_id'    => $user ? $user->id : null,
            'session_id' => $session,
            'product_id' => $validated['product_id'] ?? null,
            'order_id'   => $validated['order_id'] ?? null,
            'payload'    => json_encode($validated['payload'] ?? []),
            'source'     => $validated['source'] ?? 'website',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Format payload for CAPI
        $capiPayload = [
            'event_name' => $validated['event_name'],
            'event_time' => time(),
            'event_id'   => $eventId,
            'user_phone' => $user ? hash('sha256', $user->phone) : null,
            'user_email' => $user ? hash('sha256', $user->email) : null,
            'value'      => $validated['value'] ?? null,
            'currency'   => 'BDT',
            'product_ids'=> $validated['product_id'] ? [$validated['product_id']] : [],
        ];

        // Dispatch job to tracking queue
        dispatch(new SyncEventToFacebookCAPI($capiPayload))->onQueue('tracking');

        return response()->json([
            'success' => true,
            'message' => 'Event tracked successfully',
            'event_id' => $eventId,
        ]);
    }
}
