<?php

namespace App\Gopay\Classes;

use App\Gopay\Models\Order;
use GoPay\GoPay;
use GoPay\Definition\Language;
use GoPay\Definition\Payment\PaymentInstrument;
use GoPay\Definition\Payment\Currency;
use Illuminate\Http\Request;

class PaymentGateway
{
    protected $gopay;

    public function __construct()
    {
        $config = config('app.shop.gopay'); // cesta v OCMS môže byť config('app.shop.gopay')

        $this->gopay = GoPay::payments([
            'goid' => $config['goid'],
            'clientId' => $config['clientId'],
            'clientSecret' => $config['clientSecret'],
            'gatewayUrl' => $config['isProduction']
                ? 'https://gate.gopay.cz'
                : 'https://gw.sandbox.gopay.com',
            'scope' => GoPay::FULL,
        ]);
    }

    public function start(Order $order): string
    {
        $response = $this->gopay->createPayment([
            'payer' => [
                'default_payment_instrument' => PaymentInstrument::PAYMENT_CARD,
                'allowed_payment_instruments' => [PaymentInstrument::PAYMENT_CARD],
                'contact' => [
                    'email' => $order->customer_email ?? 'test@example.com',
                ],
            ],
            'target' => [
                'type' => 'ACCOUNT',
                'goid' => $this->gopay->getConfig()['goid'],
            ],
            'amount' => $order->total * 100, // v centoch
            'currency' => Currency::EUR,
            'order_number' => 'order-' . $order->id,
            'order_description' => 'Objednávka #' . $order->id,
            'callback' => [
                'return_url' => $config['returnUrl'],
                'notification_url' => $config['notifyUrl'],
            ],
            'language' => Language::SK,
        ]);

        if ($response->hasSucceed()) {
            $order->payment_id = $response->json['id'];
            $order->status = 'waiting';
            $order->save();

            return $response->json['gw_url'];
        }

        throw new \Exception('Nepodarilo sa vytvoriť platbu.');
    }

    public function handleCallback(Request $request): array
    {
        $paymentId = $request->input('id');

        $payment = $this->gopay->getPaymentStatus($paymentId);
        if (!$payment->hasSucceed()) {
            \Log::error('GoPay status error: ' . print_r($payment, true));
            return ['status' => 'failed'];
        }

        $state = $payment->json['state'];
        $orderId = str_replace('order-', '', $payment->json['order_number']);

        if ($state === 'PAID') {
            return [
                'status' => 'paid',
                'order_id' => $orderId,
            ];
        }

        return [
            'status' => 'waiting',
            'order_id' => $orderId,
        ];
    }
}
