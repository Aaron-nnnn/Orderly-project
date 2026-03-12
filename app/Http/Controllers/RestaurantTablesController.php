<?php

namespace App\Http\Controllers;

use App\Models\Restaurant_Tables;
use Illuminate\Http\Request;

class RestaurantTablesController extends Controller
{
    public function createRestaurantTables(Request $request){
        $validated = $request->validate([
            'restaurant_id'=>'required|exists:restaurants,id',
            'table_number'=>'required|string|max:1000',
            'total_seats'=>'required|integer|min:1',
            'status'=>'required|string|in:available, occupied, reserved',
            'occupied_until'=>'required|date',
        ]);

        $restauranttables = new Restaurant_Tables();
        $restauranttables->restaurant_id = $validated['restaurant_id'];
        $restauranttables->table_id = $validated['table_id'];
        $restauranttables->total_seats = $validated['total_seats'];
        $restauranttables->occupied_until = $validated['occupied_until'];

        try{
            $restauranttables->save();
            return response()->json($restauranttables);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to Save the RestaurantTables.',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function readAllRestaurantTables(){
        try{
             $restauranttables = Restaurant_Tables::all();
            return response()->json($restauranttables);
            }
         catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the RestaurantTables.',
                 'message'=>$exception->getMessage()
            ], 200);
         }
    }

    public function readRestaurantTables($id){
        try{
            $restauranttables = Restaurant_Tables::findOrFail($id);
            return response()->json($restauranttables);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the RestaurantTables',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function updateRestaurantTables(Request $request, $id){
        $validated = $request->validate([
            'restaurant_id'=>'required|exists:restaurants,id',
            'table_number'=>'required|string|max:1000',
            'total_seats'=>'required|integer|min:1',
            'status'=>'required|string|in:available, occupied, reserved',
            'occupied_until'=>'required|date',
        ]);

        try{
            $restauranttables = Restaurant_Tables::findOrFail($id);     
            $restauranttables = new Restaurant_Tables();
            $restauranttables->restaurant_id = $validated['restaurant_id'];
            $restauranttables->table_id = $validated['table_id'];
            $restauranttables->total_seats = $validated['total_seats'];
            $restauranttables->occupied_until = $validated['occupied_until'];
            $restauranttables->save();
            return response()->json($restauranttables);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save the RestaurantTables.',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function deleteRestaurantTables($id){
        try{
            $restauranttables = Restaurant_Tables::findOrFail($id);
            $restauranttables->delete();
            return response("RestaurantTables deleted successfully!");
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to delete the RestaurantTables.',
                'message'=>$exception->getMessage()
            ]);
        }
    }
}
