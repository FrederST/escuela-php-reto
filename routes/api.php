<?php

use App\Http\Controllers\Api\CurrencyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('currency')->group(function () {
    Route::get('', [CurrencyController::class, 'index']);
    Route::get('convert', [CurrencyController::class, 'convert']);
    Route::get('convertMultiple', [CurrencyController::class, 'convertToMultipleSource']);
});
