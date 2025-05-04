<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


Route::get('/hello',  function (){
    return"hello man";
});

// auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::post('/login', [AuthController::class, 'login']);

// user CRUD
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/users', UserController::class);
});