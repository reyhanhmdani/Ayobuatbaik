<?php

use App\Http\Controllers\DonasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/donation/{programDonasiId}', [DonasiController::class, 'store'])->name('donation.store');
Route::post('/midtrans/notification', [DonasiController::class, 'notification'])->name('midtrans.notification');
