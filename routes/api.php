<?php

use App\Http\Controllers\Api\v1\AuthControlller;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\ShoppingCartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\CartItemController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    //Auth
    Route::post('/register', [AuthControlller::class, 'register']);
    Route::post('/login', [AuthControlller::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [AuthControlller::class, 'logout']);

    Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
        return response()->json([
            'success' => true,
            'user' => $request->user(),
        ]);
    });

    //products
    Route::prefix('products')->group(function () {
        Route::get('/search', [ProductController::class, 'search']);
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
    });

    //CartItems
    // Route::prefix('cart-items')->group(function () {
    //     Route::get('/{cartId}', [CartItemController::class, 'index']); // Listar ítems de un carrito
    //     Route::post('/', [CartItemController::class, 'store']); // Agregar un ítem
    //     Route::put('/{id}', [CartItemController::class, 'update']); // Actualizar un ítem
    //     Route::delete('/{id}', [CartItemController::class, 'destroy']); // Eliminar un ítem
    // });

    Route::prefix('cart-items')->group(function () {
        Route::post('/', [CartItemController::class, 'store']);
        Route::put('/{CartItemID}', [CartItemController::class, 'update']); // Actualizar la cantidad de un CartItem
        Route::delete('/{CartItemID}', [CartItemController::class, 'destroy']); // Eliminar un CartItem
    });
    
    Route::prefix('shopping-cart')->middleware('auth:sanctum')->group(function () {
        Route::post('/', [ShoppingCartController::class, 'store']); // Crear o recuperar el carrito
        Route::get('/', [ShoppingCartController::class, 'show']);  // Mostrar el carrito con los ítems
        Route::put('/{id}', [ShoppingCartController::class, 'updateStatus']); // Actualizar el estado del carrito
    });
    
    


    //orders
    Route::prefix('orders')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('/{id}', [OrderController::class, 'show']);
        Route::post('/create', [OrderController::class, 'store']);
    });
});
