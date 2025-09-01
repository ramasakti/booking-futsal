<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\SinkronisasiController;
use App\Http\Controllers\UserInstitusiController;
use App\Http\Controllers\UserRoleController;

Route::post('/user/role', [UserRoleController::class, 'giveAndDropUserRole']);
Route::post('/access/role', [AccessController::class, 'giveAndDropAccessRole']);
Route::post('/user/institusi', [UserInstitusiController::class, 'giveAndDropUserInstitusi']);

Route::get('/sync', [SinkronisasiController::class, 'sync']);