<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\UserRoleController;

Route::post('/user/role', [UserRoleController::class, 'giveAndDropUserRole']);
Route::post('/access/role', [AccessController::class, 'giveAndDropAccessRole']);