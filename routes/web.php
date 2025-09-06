<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\TurnamenController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/registering', [AuthController::class, 'registering'])->name('registering');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Middleware 'role' untuk authorization route berdasarkan role
Route::middleware(['auth', 'role'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User
    Route::get('/user', [UsersController::class, 'index'])->name('users');
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

    // User Role
    Route::get('/user/role', [UserRoleController::class, 'userRoleIndex'])->name('user.role.index');
    Route::get('/user/role/{id_user}', [UserRoleController::class, 'userRole'])->name('user.role');

    // Akses Role
    Route::get('/access/role', [AccessController::class, 'accessRoleIndex'])->name('access.role.index');
    Route::get('/access/role/{id_role}', [AccessController::class, 'accessRole'])->name('access.role');

    // Lapangan
    Route::get('/lapangan', [LapanganController::class, 'index'])->name('lapangan.index');
    Route::get('/lapangan/create', [LapanganController::class, 'create'])->name('lapangan.create');
    Route::post('/lapangan/store', [LapanganController::class, 'store'])->name('lapangan.store');
    Route::get('/lapangan/edit/{id}', [LapanganController::class, 'edit'])->name('lapangan.edit');
    Route::put('/lapangan/update/{id}', [LapanganController::class, 'update'])->name('lapangan.update');
    Route::delete('/lapangan/delete/{id}', [LapanganController::class, 'destroy'])->name('lapangan.destroy');

    // Turnamen
    Route::get('/turnamen', [TurnamenController::class, 'index'])->name('turnamen.index');
    Route::post('/turnamen/store', [TurnamenController::class, 'store'])->name('turnamen.store');
    Route::put('/turnamen/update/{id}', [TurnamenController::class, 'update'])->name('turnamen.update');
    Route::delete('/turnamen/delete/{id}', [TurnamenController::class, 'destroy'])->name('turnamen.destroy');

    // Transaksi

    
    // Booking
    Route::get('/booking', [BookingsController::class, 'index'])->name('booking.index');
    Route::get('/booking/booking', [BookingsController::class, 'booking'])->name('booking.booking');
    Route::post('/booking/store', [BookingsController::class, 'store'])->name('booking.store');
    Route::post('/booking/{id}', [BookingsController::class, 'update'])->name('booking.update');
});
