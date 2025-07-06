<?php

namespace App\Gopay\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Gopay\Models\GopayLogs;
use App\Gopay\Models\Payment;

class WebhookController extends Controller
{
    /**
     * Spracovanie webhook notifikácie od GoPay.
     */
    public function handleWebhook(Request $request)
    {
        // Získanie údajov z webhooku
        $webhookData = $request->all();

        // Uloženie údajov do logov
        $log = new GopayLogs();
        $log->event = 'webhook_received';
        $log->data = json_encode($webhookData);
        $log->save();

        // Spracovanie platby na základe údajov z webhooku
        $payment = Payment::find($webhookData['payment_id']);
        if ($payment) {
            $payment->status = $webhookData['status'];
            $payment->save();
        }

        return response()->json(['status' => 'success']);
    }
}
