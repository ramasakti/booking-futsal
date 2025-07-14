<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessController;

Route::post('/access/role', [AccessController::class, 'giveAndDropAccessRole'])->name('access.role');