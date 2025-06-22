<?php

namespace App\Shop\Controllers;

use Backend\Classes\Controller;
use Illuminate\Http\Request;
use App\Gopay\Models\Order;
use App\Gopay\Classes\PaymentGateway;

class Orders extends Controller
{
    public $implement = [];

    public function startPayment($id)
    {
        $order = Order::findOrFail($id);
        $gateway = new PaymentGateway();

        return redirect($gateway->start($order));
    }

    public function handleCallback(Request $request)
    {
        $gateway = new PaymentGateway();
        $result = $gateway->handleCallback($request);

        if ($result['status'] === 'paid') {
            $order = Order::find($result['order_id']);
            if ($order && $order->status !== 'paid') {
                $order->status = 'paid';
                $order->save();
            }
        }

        return response('OK', 200);
    }
}
