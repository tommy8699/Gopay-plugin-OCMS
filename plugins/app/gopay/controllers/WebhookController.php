<?php

namespace App\Gopay\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use System\Classes\Controller;

class WebhookController extends Controller
{
    public function notify(Request $request)
    {
        $secret = env('GOPAY_SECRET');
        $rawBody = file_get_contents('php://input');
        $signature = hash_hmac('sha256', $rawBody, $secret);
        $incomingSignature = $request->header('X-GO-PAY-SIGNATURE');

        if (!hash_equals($signature, $incomingSignature)) {
            Log::warning('GoPay webhook: Invalid signature', [
                'expected' => $signature,
                'received' => $incomingSignature,
                'body' => $rawBody,
            ]);
            return response('Invalid signature', 403);
        }

        try {

        } catch (\Throwable $e) {
            FailedWebhook::create([
                'payload' => $rawBody,
                'signature' => $incomingSignature,
                'error' => $e->getMessage(),
            ]);
            Log::error('GoPay webhook failed', ['exception' => $e]);
            return response('Webhook processing failed', 500);
        }
    }
}
