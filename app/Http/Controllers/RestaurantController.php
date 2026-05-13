<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function createRestaurant(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:225',
            'location' => 'required|string|max:225',
            'total_tables' => 'required|integer|min:1',
            'seating_layout' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Unauthenticated'
                ], 401);
            }

            $restaurant = new Restaurant();
            $restaurant->name = $validated['name'];
            $restaurant->location = $validated['location'];
            $restaurant->total_tables = $validated['total_tables'];
            $restaurant->user_id = $user->id;

            if ($request->hasFile('seating_layout')) {
                $path = $request->file('seating_layout')
                    ->store('restaurants', 'public');

                $restaurant->seating_layout = $path;
            }

            $restaurant->save();

            return response()->json([
                'message' => 'Restaurant created successfully',
                'data' => $restaurant
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to save restaurant',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function readAllRestaurants()
    {
        try {
            return response()->json(
                Restaurant::latest()->get(),
                200
            );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch restaurants',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function readRestaurant($id)
    {
        try {
            return response()->json(
                Restaurant::findOrFail($id),
                200
            );
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Restaurant not found',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function updateRestaurant(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:225',
            'location' => 'required|string|max:225',
            'total_tables' => 'required|integer|min:1',
            'seating_layout' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Unauthenticated'
                ], 401);
            }

            $restaurant = Restaurant::findOrFail($id);

            $restaurant->name = $validated['name'];
            $restaurant->location = $validated['location'];
            $restaurant->total_tables = $validated['total_tables'];
            $restaurant->user_id = $user->id;

            if ($request->hasFile('seating_layout')) {
                $restaurant->seating_layout = $request->file('seating_layout')
                    ->store('restaurants', 'public');
            }

            $restaurant->save();

            return response()->json([
                'message' => 'Restaurant updated successfully',
                'data' => $restaurant
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update restaurant',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteRestaurant($id)
    {
        try {
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->delete();

            return response()->json([
                'message' => 'Restaurant deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete restaurant',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getOwnerRestaurants(Request $request)
    {
        return Restaurant::where('user_id', $request->user()->id)
            ->latest()
            ->get();
    }
}