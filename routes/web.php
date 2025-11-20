<?php

use App\Http\Controllers\admin\KategoriDonasiController;
use App\Http\Controllers\admin\PenggalangDanaController;
use App\Http\Controllers\Admin\ProgramDonasiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\DonasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/programs', [HomeController::class, 'programs'])->name('home.program');
Route::get('/program/{slug}', [HomeController::class, 'program'])->name('home.program.show');

Route::get('/berita', [HomeController::class, 'berita'])->name('home.berita');
Route::get('/berita/{slug}', [HomeController::class, 'showBerita'])->name('home.berita.show');

// donasi
Route::get('/donate/status/{code}', [DonasiController::class, 'showStatus'])->name('donation.status');

Route::get('/search', [HomeController::class, 'search'])->name('home.search');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes dengan middleware
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/donations', [AdminController::class, 'donations'])->name('donations');
        Route::get('/users', [AdminController::class, 'users'])->name('users');

        // CRUD Program Donasi
        Route::resource('programs', ProgramDonasiController::class)->names('programs');
        // routes/web.php
        Route::post('ckeditor/upload', [App\Http\Controllers\CKEditorController::class, 'upload'])->name('ckeditor.upload');

        Route::resource('penggalang-dana', PenggalangDanaController::class)->names('penggalang_dana');
        Route::resource('kategori-donasi', KategoriDonasiController::class)->names('kategori_donasi');
        Route::resource('sliders', SliderController::class)->names('sliders');
        Route::resource('berita', BeritaController::class)
            ->parameters(['berita' => 'berita'])
            ->names('berita');
        Route::post('/sliders/reorder', [SliderController::class, 'reorder'])->name('sliders.reorder');

        // Route untuk Donasi (Donations)
        Route::get('donasi', [AdminController::class, 'donasi'])->name('donasi.index');
    });

// Route::get('/programs', [ProgramController::class, 'index'])->name('program.index');
// Route::get('/single-program', [ProgramController::class, 'show'])->name('program.show');
