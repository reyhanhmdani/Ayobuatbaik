<?php

use App\Http\Controllers\DonasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Add rate limiting
Route::middleware('throttle:60,1')->group(function () {
    Route::post('/donation/{programDonasiId}', [DonasiController::class, 'store']);
});
Route::post('/midtrans/notification', [DonasiController::class, 'notification']);
