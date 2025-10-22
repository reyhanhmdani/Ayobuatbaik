<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('pages.home');


Route::get('/programs', [ProgramController::class, 'index'])->name('program.index');
Route::get('/single-program', [ProgramController::class, 'show'])->name('program.show');
