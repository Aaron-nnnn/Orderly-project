<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    
    public function createOrder(Request $request){
        $validated = $request->validate([
            'user_id'=>'required|exists:users,id',
            'resaurant_id'=>'required|exists:restaurants,id',
            'table_id'=>'required|exists:restaurant_tables,id',
            'total_amount'=>'required|numeric|min:0',
            'deposit_amount'=>'required|numeric|min:1',
            'balance_amount'=>'required|numeric|min:1',
            'estimated_ready_time'=>'required|integer|min:1',
            'status'=>'required|string|in:pending, confirmed',
        ]);

        $order = new Orders();
        $order->user_id = $validated['user_id'];
        $order->restaurant_id = $validated['restaurant_id'];
        $order->table_id = $validated['table_id'];
        $order->total_amount = $validated['total_amount'];
        $order->deposit_amount = $validated['deposit_amount'];
        $order->balance_amount = $validated['balance_amount'];
        $order->estimated_ready_time = $validated['estimated_ready_time'];
        $order->status = $validated['status'];

        try{
            $order->save();
            return response()->json($order);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to Save the Order.',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function readAllOrders(){
        try{
             $orders = Orders::all();
            return response()->json($orders);
            }
         catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the Orders.',
                 'message'=>$exception->getMessage()
            ], 200);
         }
    }

    public function readOrder($id){
        try{
            $order = Orders::findOrFail($id);
            return response()->json($order);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the Order',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function updateOrder(Request $request, $id){
        $validated = $request->validate([
            'user_id'=>'required|exists:users,id',
            'resaurant_id'=>'required|exists:restaurants,id',
            'table_id'=>'required|exists:restaurant_tables,id',
            'total_amount'=>'required|numeric|min:0',
            'deposit_amount'=>'required|numeric|min:1',
            'balance_amount'=>'required|numeric|min:1',
            'estimated_ready_time'=>'required|integer|min:1',
            'status'=>'required|string|in:pending, confirmed',
        ]);

        try{
            $order = Orders::findOrFail($id);
            $order->user_id = $validated['user_id'];
            $order->restaurant_id = $validated['restaurant_id'];
            $order->table_id = $validated['table_id'];
            $order->total_amount = $validated['total_amount'];
            $order->deposit_amount = $validated['deposit_amount'];
            $order->balance_amount = $validated['balance_amount'];
            $order->estimated_ready_time = $validated['estimated_ready_time'];
            $order->status = $validated['status'];
            $order->save();
            return response()->json($order);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save the Order.',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function deleteOrder($id){
        try{
            $order = Orders::findOrFail($id);
            $order->delete();
            return response("Order deleted successfully!");
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to delete the Order.',
                'message'=>$exception->getMessage()
            ]);
        }
    }
}
