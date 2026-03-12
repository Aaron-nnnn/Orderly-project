<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
     public function createRestaurant(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|max:225',
            'location'=>'required|string|max:225',
            'total_tables'=>'required|integer|min:1',
            'seating_layout'=>'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $restaurant = new Restaurant();
        $restaurant->name = $validated['name'];
        $restaurant->location = $validated['location'];
        $restaurant->total_tables = $validated['total_tables'];

        $restaurant->user_id = auth()->id;

        if ($request->hasFile('seating_layout')) {
            $restaurant->seating_layout = $request->file('seating_layout')
            ->store('seating_layouts', 'public');
        }

        try{
            $restaurant->save();
            return response()->json($restaurant);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to Save the Restaurant.',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function readAllRestaurants(){
        try{
             $restaurants = Restaurant::all();
            return response()->json($restaurants);
            }
         catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the Restaurants.',
                 'message'=>$exception->getMessage()
            ], 200);
         }
    }

    public function readRestaurant($id){
        try{
            $restaurant = Restaurant::findOrFail($id);
            return response()->json($restaurant);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the Restaurant',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function updateRestaurant(Request $request, $id){
       $validated = $request->validate([
            'name'=>'required|string|max:225',
            'location'=>'required|string|max:225',
            'total_tables'=>'required|integer|min:1',
            'seating_layout'=>'nullable|image|mimes:jpeg,png,jpg',
        ]);

        try{
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->name = $validated['name'];
            $restaurant->location = $validated['location'];
            $restaurant->total_tables = $validated['total_tables'];

            $restaurant->user_id = auth()->id;
            
             if ($request->hasFile('seating_layout')) {
                $restaurant->seating_layout = $request->file('seating_layout')
                ->store('seating_layouts', 'public');
            }

            $restaurant->save();
            return response()->json($restaurant);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save the Restaurant.',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function deleteRestaurant($id){
        try{
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->delete();
            return response("Restaurant deleted successfully!");
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to delete the Restaurant.',
                'message'=>$exception->getMessage()
            ]);
        }
    }
}
