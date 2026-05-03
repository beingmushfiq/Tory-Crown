<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $apiKey;
    protected $senderId;
    protected $baseUrl = 'https://bulksmsbd.net/api/smsapi';

    public function __construct()
    {
        $this->apiKey = config('services.bulksmsbd.api_key');
        $this->senderId = config('services.bulksmsbd.sender_id');
    }

    public function sendSms($number, $message)
    {
        $response = Http::get($this->baseUrl, [
            'api_key' => $this->apiKey,
            'type' => 'text',
            'number' => $number,
            'senderid' => $this->senderId,
            'message' => $message,
        ]);

        if (!$response->successful()) {
            Log::error("BulkSMSBD Error: " . $response->body());
        }

        return $response->successful();
    }
}
