<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnalyticsService
{
    protected $pixelId;
    protected $accessToken;
    protected $testEventCode;

    public function __construct()
    {
        $this->pixelId = config('services.facebook.pixel_id');
        $this->accessToken = config('services.facebook.access_token');
        $this->testEventCode = config('services.facebook.test_event_code');
    }

    public function sendCapiEvent($eventName, $userData, $customData, $eventId)
    {
        $payload = [
            'data' => [
                [
                    'event_name' => $eventName,
                    'event_time' => time(),
                    'event_id' => $eventId,
                    'action_source' => 'website',
                    'user_data' => $this->hashUserData($userData),
                    'custom_data' => $customData,
                ]
            ]
        ];

        if ($this->testEventCode) {
            $payload['test_event_code'] = $this->testEventCode;
        }

        $response = Http::post("https://graph.facebook.com/v17.0/{$this->pixelId}/events?access_token={$this->accessToken}", $payload);

        if (!$response->successful()) {
            Log::error("Facebook CAPI Error: " . $response->body());
        }

        return $response->successful();
    }

    protected function hashUserData($data)
    {
        $hashed = [];
        foreach ($data as $key => $value) {
            if (in_array($key, ['em', 'ph', 'fn', 'ln', 'ct', 'st', 'zp', 'country'])) {
                $hashed[$key] = hash('sha256', strtolower(trim($value)));
            } else {
                $hashed[$key] = $value; // client_ip_address, client_user_agent etc don't need hashing
            }
        }
        return $hashed;
    }
}
