<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

// Auth routes (public)
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index']);

Route::post('question/store', [QuestionController::class, 'store'])
        ->name('question.store');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['checkislogin'])->name('dashboard');

Route::resource('category', CategoryController::class)->middleware(['checkislogin']);
Route::resource('post', PostController::class)->middleware(['checkislogin']);

Route::middleware(['auth'])->group(function () {
    Route::middleware(['checkrole:Super Admin'])->group(function () {
        Route::resource('user', UserController::class);
    });

    Route::middleware(['checkrole:Super Admin,mitra'])->group(function () {
        Route::resource('pelanggan', PelangganController::class);
    });
});
