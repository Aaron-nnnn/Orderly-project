<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function payOrder(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string',
            'amount_paid' => 'required|numeric|min:1',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        if ($validated['amount_paid'] < $order->total_amount) {
            return response()->json([
                'message' => 'Insufficient payment amount'
            ], 400);
        }

        $order->payment_method = $validated['payment_method'];
        $order->amount_paid = $validated['amount_paid'];
        $order->is_paid = true;
        $order->status = 'completed';
        $order->save();

        if ($order->order_type === 'dine_in' && $order->table_id) {

            $table = RestaurantTable::find($order->table_id);

            if ($table) {
                $table->status = 'available';
                $table->occupied_until = null;
                $table->save();
            }
        }

        if ($order->order_type === 'dine_in' && $order->table_id) {
        $table = RestaurantTable::find($order->table_id);
        if ($table) {
            $table->update([
                'status' => 'available',
                'occupied_until' => null
            ]);
        }
    }

        return response()->json([
            'message' => 'Payment successful',
            'order' => $order
        ]);
    }
}