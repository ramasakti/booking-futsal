<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BebanKegiatanController;
use App\Http\Controllers\BukuPenghubungController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstitusiController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MasterKegiatanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OCRController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SinkronisasiController;
use App\Http\Controllers\UserInstitusiController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UsersController;

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
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

    // Sinkron
    Route::get('/sync', [SinkronisasiController::class, 'index']);

    // Institusi
    Route::get('/institusi', [InstitusiController::class, 'index'])->name('institusi');
    Route::post('/institusi/store', [InstitusiController::class, 'store'])->name('institusi.store');
    Route::put('/institusi/update/{id}', [InstitusiController::class, 'update'])->name('institusi.update');
    Route::delete('/institusi/destroy/{id}', [InstitusiController::class, 'destroy'])->name('institusi.destroy');

    // Kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');

    // Catatan
    Route::get('/catatan', [BukuPenghubungController::class, 'catatan'])->name('catatan');
    Route::get('/catatan/{id_kelas}', [BukuPenghubungController::class, 'catatanKelas'])->name('catatan.kelas');

    // User Institusi
    Route::get('/user/institusi', [UserInstitusiController::class, 'userInstitusiIndex'])->name('user.institusi.index');
    Route::get('/user/institusi/{id_user}', [UserInstitusiController::class, 'userInstitusi'])->name('user.institusi');

    // Kegiatan
    Route::get('/master_kegiatan', [MasterKegiatanController::class, 'index'])->name('kegiatan.index');

    // Beban Kegiatan
    Route::get('/beban_kegiatan', [BebanKegiatanController::class, 'index'])->name('beban_kegiatan.index');
});
