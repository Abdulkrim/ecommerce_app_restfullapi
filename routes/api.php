<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


Route::prefix('ecommerce_app')->group(function () {

    Route::get('/hello',  function (){
        return"hello man";
    });
    
    // =================== Auth ===================
    
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/verify-code', [AuthController::class, 'verifyCode']);
        Route::post('/login', [AuthController::class, 'login']);
    });
    
    // =================== User CRUD ===================

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/users', UserController::class);
    });

});