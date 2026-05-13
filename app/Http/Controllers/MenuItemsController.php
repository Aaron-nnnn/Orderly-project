<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemsController extends Controller
{
    public function createMenuItem(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|integer|exists:restaurants,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'preparation_time' => 'required|integer|min:1',
            'is_available' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        try {
            $menu = new MenuItem();
            $menu->restaurant_id = $validated['restaurant_id'];
            $menu->name = $validated['name'];
            $menu->price = $validated['price'];
            $menu->preparation_time = $validated['preparation_time'];
            $menu->is_available = $validated['is_available'];

            if ($request->hasFile('image')) {
                $menu->image = $request->file('image')->store('menu_items', 'public');
            }

            $menu->save();

            return response()->json([
                'message' => 'Menu item created successfully',
                'data' => $menu
            ], 201);

        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Failed to save menu item',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function readAllMenuItems()
    {
        return MenuItem::latest()->get();
    }

    public function readMenuItem($id)
    {
        return MenuItem::findOrFail($id);
    }

    public function updateMenuItem(Request $request, $id)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|integer|exists:restaurants,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'preparation_time' => 'required|integer|min:1',
            'is_available' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        try {
            $menu = MenuItem::findOrFail($id);

            $menu->restaurant_id = $validated['restaurant_id'];
            $menu->name = $validated['name'];
            $menu->price = $validated['price'];
            $menu->preparation_time = $validated['preparation_time'];
            $menu->is_available = $validated['is_available'];

            if ($request->hasFile('image')) {
                $menu->image = $request->file('image')->store('menu_items', 'public');
            }

            $menu->save();

            return response()->json([
                'message' => 'Menu item updated successfully',
                'data' => $menu
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Failed to update menu item',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function deleteMenuItem($id)
    {
        try {
            $menu = MenuItem::findOrFail($id);
            $menu->delete();

            return response()->json([
                'message' => 'Menu item deleted successfully'
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Failed to delete menu item',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function getByRestaurant($restaurantId)
    {
        try {
            $menuItems = MenuItem::where('restaurant_id', $restaurantId)->get();

            return response()->json($menuItems, 200);

        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Failed to get menu items',
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}