<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User
    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::post('/user/store', [UsersController::class, 'store'])->name('user.store');
    Route::put('/user/update/{id}', [UsersController::class, 'update'])->name('user.update');
    Route::delete('/user/destroy/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
    Route::get('/user/detail/{id}', [UsersController::class, 'detail'])->name('user.detail');

    // Role
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

    // Menu
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    Route::post('/menu/update', [MenuController::class, 'update'])->name('menu.update');
});
