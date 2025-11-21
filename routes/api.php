<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlomdaProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| هنا يتم تعريف جميع Routes الخاصة بـ API.
|
*/

Route::get('/showcase', [AlomdaProductController::class, 'showcase']);
use App\Http\Controllers\Api\AddressController;

Route::get('/addresses', [AddressController::class, 'index']);
