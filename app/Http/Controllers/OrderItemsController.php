<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemsController extends Controller
{
    public function createOrderItem(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            $orderItem = OrderItem::create($validated);

            return response()->json([
                'message' => 'Order item created successfully',
                'data' => $orderItem
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Failed to save OrderItem',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function readAllOrderItems()
    {
        return response()->json(OrderItem::all());
    }

    public function readOrderItem($id)
    {
        try {
            return response()->json(OrderItem::findOrFail($id));
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'OrderItem not found',
                'message' => $exception->getMessage()
            ], 404);
        }
    }

    public function updateOrderItem(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            $orderItem = OrderItem::findOrFail($id);
            $orderItem->update($validated);

            return response()->json([
                'message' => 'Order item updated',
                'data' => $orderItem
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Update failed',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function deleteOrderItem($id)
    {
        try {
            $orderItem = OrderItem::findOrFail($id);
            $orderItem->delete();

            return response()->json([
                'message' => 'OrderItem deleted successfully'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Delete failed',
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}