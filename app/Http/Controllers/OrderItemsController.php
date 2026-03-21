<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemsController extends Controller
{
    public function createOrderItem(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|unique:order_items,name',
        ]);

        $order_item = new OrderItem();
        $order_item->name = $validated['name'];

        try{
            $order_item->save();
            return response()->json($order_item);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to Save the OrderItem.',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function readAllOrderItems(){
        try{
             $order_item = OrderItem::all();
            return response()->json($order_item);
            }
         catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the OrderItems.',
                 'message'=>$exception->getMessage()
            ], 200);
         }
    }

    public function readOrderItem($id){
        try{
            $order_item = OrderItem::findOrFail($id);
            return response()->json($order_item);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the OrderItem',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function updateOrderItem(Request $request, $id){
        $validated = $request->validate([
            'name'=>'required|string',
        ]);

        try{
            $order_item = OrderItem::findOrFail($id);
            $order_item->name = $validated['name'];
            $order_item->save();
            return response()->json($order_item);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save the OrderItem.',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function deleteOrderItem($id){
        try{
            $order_item = OrderItem::findOrFail($id);
            $order_item->delete();
            return response("OrderItem deleted successfully!");
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to delete the OrderItem.',
                'message'=>$exception->getMessage()
            ]);
        }
    }
}
