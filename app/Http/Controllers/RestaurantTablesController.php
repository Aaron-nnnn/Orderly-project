<?php

namespace App\Http\Controllers;

use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class RestaurantTablesController extends Controller
{
    public function createRestaurantTable(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'table_number' => 'required|integer',
            'total_seats' => 'required|integer|min:1',
            'status' => 'nullable|in:available,reserved,occupied',
            'occupied_until' => 'nullable|date'
        ]);

        try {
            $table = RestaurantTable::create([
                'restaurant_id' => $validated['restaurant_id'],
                'table_number' => $validated['table_number'],
                'total_seats' => $validated['total_seats'],
                'status' => $validated['status'] ?? 'available',
                'occupied_until' => $validated['occupied_until'] ?? null,
            ]);

            return response()->json([
                'message' => 'Table created successfully',
                'table' => $table
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create table',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function readAllRestaurantTables()
    {
        return RestaurantTable::all();
    }

    public function readRestaurantTable($id)
    {
        return RestaurantTable::findOrFail($id);
    }

    public function getByRestaurant($restaurantId)
    {
        return RestaurantTable::where('restaurant_id', $restaurantId)->get();
    }

    public function updateRestaurantTable(Request $request, $id)
    {
        $validated = $request->validate([
            'table_number' => 'sometimes|integer',
            'total_seats' => 'sometimes|integer|min:1',
            'status' => 'sometimes|in:available,reserved,occupied',
            'occupied_until' => 'nullable|date'
        ]);

        $table = RestaurantTable::findOrFail($id);
        $table->update($validated);

        return response()->json([
            'message' => 'Table updated successfully',
            'table' => $table
        ]);
    }

    public function deleteRestaurantTable($id)
    {
        RestaurantTable::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Table deleted successfully'
        ]);
    }

    public function occupyTable($id)
    {
        $table = RestaurantTable::findOrFail($id);

        $table->update([
            'status' => 'occupied'
        ]);

        return response()->json([
            'message' => 'Table marked as occupied',
            'table' => $table
        ]);
    }

    public function releaseTable($id)
    {
        $table = RestaurantTable::findOrFail($id);

        $table->update([
            'status' => 'available',
            'occupied_until' => null
        ]);

        return response()->json([
            'message' => 'Table released',
            'table' => $table
        ]);
    }
}