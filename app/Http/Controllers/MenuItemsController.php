<?php

namespace App\Http\Controllers;

use App\Models\MenuItems;
use Illuminate\Http\Request;

class MenuItemsController extends Controller
{
    public function createMenuItems(Request $request){
        $validated = $request->validate([
            'restaurant_id'=>'required|integer|exists:restaurants,id',
            'name'=>'required|string|max:255',
            'price'=>'required|numeric|min:1',
            'preparation_time'=>'required|integer|min:1',
            'is_available'=>'required|boolean',
        ]);

        $menuitems = new MenuItems();
        $menuitems->restaurant_id = $validated['restaurant_id'];
        $menuitems->name = $validated['name'];
        $menuitems->price = $validated['price'];
        $menuitems->preparation_time = $validated['preparation_time'];
        $menuitems->is_available = $validated['is_available'];

        try{
            $menuitems->save();
            return response()->json($menuitems);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to Save the MenuItems.',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function readAllMenuItems(){
        try{
             $menuitems = MenuItems::all();
            return response()->json($menuitems);
            }
         catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the MenuItems.',
                 'message'=>$exception->getMessage()
            ], 200);
         }
    }

    public function readMenuItems($id){
        try{
            $menuitems = MenuItems::findOrFail($id);
            return response()->json($menuitems);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to get the MenuItems',
                'message'=>$exception->getMessage()
            ], 200);
        }
    }

    public function updateMenuItems(Request $request, $id){
        $validated = $request->validate([
            'restaurant_id'=>'required|integer|exists:restaurants,id',
            'name'=>'required|string|max:255',
            'price'=>'required|numeric|min:0',
            'preparation_time'=>'required|integer|min:1',
            'is_available'=>'required|boolean',
        ]);

        try{
            $menuitems = MenuItems::findOrFail($id);
            $menuitems->restaurant_id = $validated['restaurant_id'];
            $menuitems->name = $validated['name'];
            $menuitems->price = $validated['price'];
            $menuitems->preparation_time = $validated['preparation_time'];
            $menuitems->is_available = $validated['is_available'];

            $menuitems->save();
            return response()->json($menuitems);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to save the MenuItems.',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function deleteMenuItems($id){
        try{
            $menuitems = MenuItems::findOrFail($id);
            $menuitems->delete();
            return response("MenuItems deleted successfully!");
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to delete the MenuItems.',
                'message'=>$exception->getMessage()
            ]);
        }
    }
}
