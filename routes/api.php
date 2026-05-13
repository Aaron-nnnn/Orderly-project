<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuItemsController;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OwnerRequestController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestaurantTablesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/getRestaurants', [RestaurantController::class, 'readAllRestaurants']);
Route::get('/getRestaurant/{id}', [RestaurantController::class, 'readRestaurant']);

Route::get('/getRestaurantTables/{restaurantId}',[RestaurantTablesController::class,'getByRestaurant']);
Route::get('/getRestaurantTable/{id}', [RestaurantTablesController::class, 'readRestaurantTable']);

Route::get('/getMenuItems', [MenuItemsController::class, 'readAllMenuItems']);
Route::get('/getMenuItems/{restaurantId}', [MenuItemsController::class, 'getByRestaurant']);
Route::get('/getMenuItem/{id}', [MenuItemsController::class, 'readMenuItem']);

Route::get('/getOrders', [OrdersController::class, 'readAllOrders']);
Route::get('/myOrders', [OrdersController::class, 'readAllOrders']);
Route::post('/saveOrder', [OrdersController::class, 'createOrder']);

Route::get('/getOrderItems', [OrderItemsController::class, 'readAllOrderItems']);
Route::get('/getOrderItem/{id}', [OrderItemsController::class, 'readOrderItem']);

Route::post('/owner-request', [OwnerRequestController::class, 'store']);
Route::get('/my-owner-requests', [OwnerRequestController::class, 'myRequests']);
Route::get('/owner-request/status', [OwnerRequestController::class, 'status']);

Route::post('payOrder', [PaymentsController::class, 'payOrder']);
});

// Admin
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

Route::post('/saveRole', [RoleController::class, 'createRole']);
Route::get('/getRoles', [RoleController::class, 'readAllRoles']);
Route::get('/getRole/{id}', [RoleController::class, 'readRole']);
Route::post('/updateRole/{id}', [RoleController::class, 'updateRole']);
Route::delete('/deleteRole/{id}', [RoleController::class, 'deleteRole']);

Route::get('/owner-requests', [OwnerRequestController::class, 'index']);
Route::post('/owner-requests/{id}/approve', [OwnerRequestController::class, 'approve']);
Route::post('/owner-requests/{id}/reject', [OwnerRequestController::class, 'reject']);
Route::delete('/owner-requests/{id}', [OwnerRequestController::class, 'destroy']);

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);

});

// Restaurant
Route::middleware(['auth:sanctum', 'restaurant'])->group(function () {

Route::get('/owner/restaurants', [RestaurantController::class, 'getOwnerRestaurants']);

Route::post('/saveRestaurant', [RestaurantController::class, 'createRestaurant']);
Route::post('/updateRestaurant/{id}', [RestaurantController::class, 'updateRestaurant']);
Route::delete('/deleteRestaurant/{id}', [RestaurantController::class, 'deleteRestaurant']);

Route::post('/saveRestaurantTable', [RestaurantTablesController::class, 'createRestaurantTable']);
Route::post('/updateRestaurantTable/{id}', [RestaurantTablesController::class, 'updateRestaurantTable']);
Route::delete('/deleteRestaurantTable/{id}', [RestaurantTablesController::class, 'deleteRestaurantTable']);

Route::post('/saveMenuItem', [MenuItemsController::class, 'createMenuItem']);
Route::post('/updateMenuItem/{id}', [MenuItemsController::class, 'updateMenuItem']);
Route::delete('/deleteMenuItem/{id}', [MenuItemsController::class, 'deleteMenuItem']);

Route::get('/getOrder/{id}', [OrdersController::class, 'readOrder']);
Route::post('/updateOrderStatus/{id}', [OrdersController::class, 'updateOrderStatus']);
Route::delete('/deleteOrder/{id}', [OrdersController::class, 'deleteOrder']);
Route::get('/restaurant/orders/{restaurantId}', [OrdersController::class, 'getByRestaurant']);

Route::post('/saveOrderItem', [OrderItemsController::class, 'createOrderItem']);
Route::post('/updateOrderItem/{id}', [OrderItemsController::class, 'updateOrderItem']);
Route::delete('/deleteOrderItem/{id}', [OrderItemsController::class, 'deleteOrderItem']);
});

