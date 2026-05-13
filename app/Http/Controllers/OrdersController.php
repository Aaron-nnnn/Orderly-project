<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function createOrder(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'table_id' => 'nullable|exists:restaurant_tables,id',
            'order_type' => 'required|in:dine_in,takeaway',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'required|array'
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'restaurant_id' => $validated['restaurant_id'],
            'table_id' => $validated['table_id'] ?? null,
            'order_type' => $validated['order_type'],
            'total_amount' => $validated['total_amount'],
            'status' => 'pending'
        ]);

        if ($order->order_type === 'dine_in' && $order->table_id) {
            RestaurantTable::where('id', $order->table_id)
                ->update(['status' => 'occupied']);
        }

        foreach ($validated['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order
        ], 201);
    }

    public function readAllOrders()
    {
        return Order::with('items.menuItem')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    }

    public function getByRestaurant($restaurantId)
    {
        return Order::with(['items.menuItem', 'user'])
            ->where('restaurant_id', $restaurantId)
            ->latest()
            ->get();
    }

    public function readOrder($id)
    {
        return Order::with('items.menuItem')->findOrFail($id);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $validated['status'];
        $order->save();

        return response()->json([
            'message' => 'Order status updated',
            'order' => $order
        ]);
    }

    public function deleteOrder($id)
    {
        Order::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Order deleted'
        ]);
    }
}