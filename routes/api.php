<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/student/login', [AuthController::class, 'studentLogin']);
Route::post('/guardian/login', [AuthController::class, 'guardianLogin']);
