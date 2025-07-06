<?php

namespace App\Gopay\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Gopay\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Vytvorenie novej objednávky.
     */
    public function createOrder(Request $request)
    {
        $order = new Orders();
        $order->user_id = $request->user_id;
        $order->amount = $request->amount;
        $order->status = 'pending';
        $order->save();

        return response()->json(['status' => 'success', 'order_id' => $order->id]);
    }

    /**
     * Zobrazenie objednávky podľa ID.
     */
    public function show($id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    /**
     * Aktualizácia stavu objednávky.
     */
    public function updateOrderStatus($id, Request $request)
    {
        $order = Orders::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json(['status' => 'success', 'order' => $order]);
    }
}
