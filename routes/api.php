<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EpaycoController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('products', ProductController::class)->except(['create', 'edit']);
    Route::get('/cart', [CartController::class, 'show']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeFromCart']);
    Route::get('/cart/taxes', [CartController::class, 'calculateTaxes']);
    Route::get('/check-token', [AuthController::class, 'checkToken']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/delete-cart', [CartController::class, 'clearCart']);
});
Route::post('/start-pay', [EpaycoController::class, 'startPay']);
Route::get('/response-pay', [EpaycoController::class, 'responsePay']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);

/*
Route::get('/admin', function () {
    return 'Admin Page';
})->middleware('role:admin');*/
