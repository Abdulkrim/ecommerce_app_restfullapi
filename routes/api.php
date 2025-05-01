<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AuthController;


Route::get('/hello',  function (){
    return"hello man";
});

// auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::post('/login', [AuthController::class, 'login']);