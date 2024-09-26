<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\CategoryController;


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderControler;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);


Route::middleware('auth:sanctum')->group(function () {
    // Dashboard route
    Route::get('admin/dashboard', [DashboardController::class, 'index']);

    // Product routes
    Route::prefix('admin/products')->group(function () {
        Route::get('/', [AdminProductController::class, 'index']);
        Route::post('/', [AdminProductController::class, 'store']);
        Route::get('/{id}', [AdminProductController::class, 'show']);
        Route::put('/{id}', [AdminProductController::class, 'update']);
        Route::delete('/{id}', [AdminProductController::class, 'destroy']);
    });

    // Order routes
    Route::prefix('admin/orders')->group(function () {
        Route::get('/', [AdminOrderControler::class, 'index']);
        Route::get('/{id}', [AdminOrderControler::class, 'show']);
        Route::put('/{id}', [AdminOrderControler::class, 'update']);
        Route::delete('/{id}', [AdminOrderControler::class, 'destroy']);
    });

    // User routes
    Route::prefix('admin/users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    // Category routes
    Route::prefix('admin/categories')->group(function () {
        Route::get('/', [AdminCategoryController::class, 'index']);
        Route::post('/', [AdminCategoryController::class, 'store']);
        Route::get('/{id}', [AdminCategoryController::class, 'show']);
        Route::put('/{id}', [AdminCategoryController::class, 'update']);
        Route::delete('/{id}', [AdminCategoryController::class, 'destroy']);
    });

    // Review routes
    Route::prefix('admin/reviews')->group(function () {
        Route::get('/', [ReviewController::class, 'index']);
        Route::get('/{id}', [ReviewController::class, 'show']);
        Route::put('/{id}', [ReviewController::class, 'update']);
        Route::delete('/{id}', [ReviewController::class, 'destroy']);
    });

    // Settings routes
    Route::prefix('admin/settings')->group(function () {
        Route::get('/', [SettingController::class, 'index']);
        Route::put('/', [SettingController::class, 'update']);
    });
});

Route::get('categories', [CategoryController::class, 'index']); // View all products


Route::get('/', [HomeController::class, 'index']); // Home page
Route::get('products', [ProductController::class, 'index']); // View all products
Route::get('products/{id}', [ProductController::class, 'show']); // View a specific product

// Cart routes
// Cart routes
Route::prefix('cart')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [CartController::class, 'index']); // Get cart items
    Route::post('/addtocart/{id}', [CartController::class, 'store']); // Add item to cart using product ID in the URL
    Route::delete('/{id}', [CartController::class, 'destroy']); 
});


// Order routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders', [OrderController::class, 'getUserOrders']);
    Route::post('/orders', [OrderController::class, 'store']);
   Route::get('/orders/{id}', [OrderController::class, 'show']);
   Route::post('/payment/create-intent', [OrderController::class, 'createPaymentIntent']);
    Route::post('/paypal/capture', [OrderController::class, 'capturePayPalPayment']);
   


});





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

