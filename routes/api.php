<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgetPasswordController;


Route::prefix('ecommerce_app')->group(function () {

    // =================== Start App =======================

    Route::get('/hello',  function (){
        return"hello man";
    });
    
    // =================== Auth =======================

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/verify-code', [AuthController::class, 'verifyCode']);
        Route::post('/login', [AuthController::class, 'login']);
    });
    
    // =================== User CRUD ===================

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/users', UserController::class);
    });

    // =================== Forget Passwoed ===================
    
    Route::prefix('forget-password')->group(function () {
        Route::post('/check-email', [ForgetPasswordController::class, 'checkEmail']);
        Route::post('/reset-password', [ForgetPasswordController::class, 'resetPassword']);
    });
});