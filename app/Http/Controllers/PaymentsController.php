<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
     public function createPayments(Request $request){
        $validated = $request->validate([
            'order_id'=>'required|string|exists:orders,id',
            'amount'=>'required|string|min:1',
            'type'=>'required|string|unique:payments,name',
            'status'=>'required|string|in:paid, pending',
            'method'=>'required|string|',
        ]);

        $payments = new Payments();
        $payments->order_id = $validated['order_id'];
        $payments->amount = $validated['amount'];
        $payments->type = $validated['type'];
        $payments->status = $validated['status'];
        $payments->method = $validated['method'];

        try{
            $payments->save();
            return response()->json($payments);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to Save the Payments.',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function readAllPayments(){
        try{
             $payments = Payments::all();
            return response()->json($payments);
            }
         catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the Payments.',
                 'message'=>$exception->getMessage()
            ], 200);
         }
    }

    public function readPayments($id){
        try{
            $payments = Payments::findOrFail($id);
            return response()->json($payments);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the Payments',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function updatePayments(Request $request, $id){
        $validated = $request->validate([
            'order_id'=>'required|string|exists:orders,id',
            'amount'=>'required|string|min:1',
            'type'=>'required|string|unique:payments,name',
            'status'=>'required|string|in:paid, pending',
            'method'=>'required|string|',
        ]);

        try{
            $payments = Payments::findOrFail($id);
            $payments->order_id = $validated['order_id'];
            $payments->amount = $validated['amount'];
            $payments->type = $validated['type'];
            $payments->status = $validated['status'];
            $payments->method = $validated['method'];
            $payments->save();
            return response()->json($payments);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save the Payments.',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function deletePayments($id){
        try{
            $payments = Payments::findOrFail($id);
            $payments->delete();
            return response("Payments deleted successfully!");
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to delete the Payments.',
                'message'=>$exception->getMessage()
            ]);
        }
    }
}
