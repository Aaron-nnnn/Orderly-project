<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuItemsController;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ResendEmailVerificationController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestaurantTablesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
    ->name('verification.verify')
    ->middleware(['signed', 'throttle:6,1']);

Route::post('/email/resend', [ResendEmailVerificationController::class, 'resend'])
    ->middleware('auth:sanctum', 'throttle:6,1');

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {

Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('admin')->group(function () {

Route::post('/saveRole', [RoleController::class, 'createRole']);
Route::get('/getRoles', [RoleController::class, 'readAllRoles']);
Route::get('/getRole/{id}', [RoleController::class, 'readRole']);
Route::post('/updateRole/{id}', [RoleController::class, 'updateRole']);
Route::delete('/deleteRole/{id}', [RoleController::class, 'deleteRole']);

});

Route::middleware(['auth:sanctum', 'restaurant'])->group(function () {

Route::post('/saveRestaurant', [RestaurantController::class, 'createRestaurant']);
Route::post('/updateRestaurant/{id}', [RestaurantController::class, 'updateRestaurant']);
Route::delete('/deleteRestaurant/{id}', [RestaurantController::class, 'deleteRestaurant']);

Route::post('/saveRestaurantTable', [RestaurantTablesController::class, 'createRestaurantTable']);
Route::post('/updateRestaurantTable/{id}', [RestaurantTablesController::class, 'updateRestaurantTable']);
Route::delete('/deleteRestaurantTable/{id}', [RestaurantTablesController::class, 'deleteRestaurantTable']);

Route::post('/saveMenuItem', [MenuItemsController::class, 'createMenuItem']);
Route::post('/updateMenuItem/{id}', [MenuItemsController::class, 'updateMenuItem']);
Route::delete('/deleteMenuItem/{id}', [MenuItemsController::class, 'deleteMenuItem']);

Route::post('/saveOrder', [OrdersController::class, 'createOrder']);
Route::post('/updateOrder/{id}', [OrdersController::class, 'updateOrder']);
Route::delete('/deleteOrder/{id}', [OrdersController::class, 'deleteOrder']);

Route::post('/saveOrderItem', [OrderItemsController::class, 'createOrderItem']);
Route::post('/updateOrderItem/{id}', [OrderItemsController::class, 'updateOrderItem']);
Route::delete('/deleteOrderItem/{id}', [OrderItemsController::class, 'deleteOrderItem']);

Route::post('/savePayment', [PaymentsController::class, 'createPayment']);
Route::post('/updatePayment/{id}', [PaymentsController::class, 'updatePayment']);
Route::delete('/deletePayment/{id}', [PaymentsController::class, 'deletePayment']);
});

Route::get('/getRestaurants', [RestaurantController::class, 'readAllRestaurants']);
Route::get('/getRestaurant/{id}', [RestaurantController::class, 'readRestaurant']);

Route::get('/getRestaurantTables', [RestaurantTablesController::class, 'readAllRestaurantTables']);
Route::get('/getRestaurantTable/{id}', [RestaurantTablesController::class, 'readRestaurantTable']);

Route::get('/getMenuItems', [MenuItemsController::class, 'readAllMenuItems']);
Route::get('/getMenuItem/{id}', [MenuItemsController::class, 'readMenuItem']);

Route::get('/getOrders', [OrdersController::class, 'readAllOrders']);
Route::get('/getOrder/{id}', [OrdersController::class, 'readOrder']);

Route::get('/getOrderItems', [OrderItemsController::class, 'readAllOrderItems']);
Route::get('/getOrderItem/{id}', [OrderItemsController::class, 'readOrderItem']);

Route::get('/getPayments', [PaymentsController::class, 'readAllPayments']);
Route::get('/getPayment/{id}', [PaymentsController::class, 'readPayment']);
});