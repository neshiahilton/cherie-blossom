<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BouquetController;

Route::prefix('user')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login1', [AuthController::class, 'login1'])->name('login'); // opsional
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::get('/whoami', function (Request $request) {
        return $request->user();
    })->middleware('auth:api');
});

// Route publik untuk melihat data bouquets
Route::resource('bouquets', BouquetController::class)
    ->only(['index', 'show']);

// Route privat untuk mengubah data bouquets (butuh token)
Route::resource('bouquets', BouquetController::class)
    ->except(['index', 'show'])
    ->middleware('auth:api');
