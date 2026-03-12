<?php

namespace App\Http\Controllers;

use App\Models\Order_Items;
use Illuminate\Http\Request;

class Order_ItemsController extends Controller
{
    public function createOrder_Item(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|unique:order_items,name',
        ]);

        $order_item = new Order_Items();
        $order_item->name = $validated['name'];

        try{
            $order_item->save();
            return response()->json($order_item);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to Save the Order_Item.',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function readAllOrder_Items(){
        try{
             $order_items = Order_Items::all();
            return response()->json($order_items);
            }
         catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the Order_Items.',
                 'message'=>$exception->getMessage()
            ], 200);
         }
    }

    public function readOrder_Item($id){
        try{
            $order_item = Order_Items::findOrFail($id);
            return response()->json($order_item);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the Order_Item',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function updateOrder_Item(Request $request, $id){
        $validated = $request->validate([
            'name'=>'required|string',
        ]);

        try{
            $order_item = Order_Items::findOrFail($id);
            $order_item->name = $validated['name'];
            $order_item->save();
            return response()->json($order_item);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save the Order_Item.',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function deleteOrder_Item($id){
        try{
            $order_item = Order_Items::findOrFail($id);
            $order_item->delete();
            return response("Order_Item deleted successfully!");
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to delete the Order_Item.',
                'message'=>$exception->getMessage()
            ]);
        }
    }
}
