<?php

use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/auth/login', [UserController::class, 'login']);
Route::post('/auth/register', [UserController::class, 'register']);

// Protected Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [UserController::class, 'logout']);
    Route::post('/auth/check', [UserController::class, 'check']);

    Route::group(['prefix' => 'user'], function () {

        Route::get('/', function (Request $request) {
            return $request->user();
        });

        Route::group(['prefix' => 'wallets'], function () {
            Route::get('/', [WalletController::class, 'index']);
            Route::post('/', [WalletController::class, 'create']);
            Route::get('/{walletNumber}', [WalletController::class, 'show']);
            Route::put('/{walletNumber}', [WalletController::class, 'update']);
            Route::delete('/{walletNumber}', [WalletController::class, 'delete']);

            Route::group(['prefix' => '/{walletNumber}/transactions'], function () {
                Route::get('/', [TransactionController::class, 'index']);

                Route::post('/', [TransactionController::class, 'create']);
            });
        });

    });
});

Route::get('/', function () {
    return 'I am working';
});
