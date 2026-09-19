<?php
use App\Http\Controllers\Api\{AuthController,GuardianPortalController,RegistrationController,StudentPortalController};
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:5,1')->group(function(){
    Route::post('/student/login',[AuthController::class,'studentLogin']);
    Route::post('/guardian/login',[AuthController::class,'guardianLogin']);
});
Route::get('/registration/options',[RegistrationController::class,'options']);
Route::post('/student/register',[RegistrationController::class,'student'])->middleware('throttle:10,1');
Route::post('/guardian/register',[RegistrationController::class,'guardian'])->middleware('throttle:10,1');

Route::middleware('mobile')->group(function(){
    Route::get('/me',[AuthController::class,'me']);
    Route::post('/logout',[AuthController::class,'logout']);
});
Route::prefix('student')->middleware('mobile:student')->group(function(){
    Route::get('/dashboard',[StudentPortalController::class,'dashboard']);
    Route::get('/subjects',[StudentPortalController::class,'subjects']);
    Route::get('/grades',[StudentPortalController::class,'grades']);
    Route::get('/profile',[StudentPortalController::class,'profile']);
    Route::put('/profile',[StudentPortalController::class,'updateProfile']);
});
Route::prefix('guardian')->middleware('mobile:guardian')->group(function(){
    Route::get('/dashboard',[GuardianPortalController::class,'dashboard']);
    Route::get('/children',[GuardianPortalController::class,'children']);
    Route::get('/children/{student}',[GuardianPortalController::class,'child']);
    Route::get('/children/{student}/grades',[GuardianPortalController::class,'grades']);
    Route::get('/profile',[GuardianPortalController::class,'profile']);
    Route::put('/profile',[GuardianPortalController::class,'updateProfile']);
});
