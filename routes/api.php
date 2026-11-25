<?php

use App\Http\Controllers\API\BPN\BphtbApiController;
use App\Http\Controllers\API\BPN\PbbApiController;
use App\Http\Middleware\ValidateApiKey;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:bpn-api'])->group(function () {
    Route::controller(BphtbApiController::class)->group(function () {
        Route::post('getBPHTBService', 'index');
        Route::post('getStatusNIBService', 'getStatusNIBService');
    });

    Route::controller(PbbApiController::class)->group(function () {
        Route::get('getPBBService', 'index');
    });
});
