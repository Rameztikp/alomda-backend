<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlomdaProductController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| هنا يتم تعريف جميع Routes الخاصة بـ API.
|
*/

// Public routes
Route::get('/showcase', [AlomdaProductController::class, 'showcase']);
Route::get('/addresses', [AddressController::class, 'index']);

// Storage route for file access
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (file_exists($filePath)) {
        return response()->file($filePath, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => '*',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
    abort(404);
})->where('path', '.*');

// Product management routes
Route::prefix('products')->group(function () {
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{product}', [ProductController::class, 'update']);
    // Add more routes as needed (e.g., delete, show, etc.)
});
