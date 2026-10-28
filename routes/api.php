<?php

use App\Http\Controllers\API\BPN\BphtbApiController;
use App\Http\Controllers\API\BPN\PbbApiController;
use App\Http\Middleware\ValidateApiKey;
use Illuminate\Support\Facades\Route;

Route::middleware([ValidateApiKey::class, 'throttle:bpn-api'])->group(function () {
    Route::controller(BphtbApiController::class)->group(function () {
        Route::post('GetBPHTBService', 'index');
        Route::post('GetStatusNIBService', 'getStatusNIBService');

        // Alternative URL
        Route::post('getBPHTBService', 'index');
        Route::post('getStatusNIBService', 'getStatusNIBService');
    });

    Route::controller(PbbApiController::class)->group(function () {
        Route::post('GetPBBService', 'index');
        Route::get('GetPBBService', 'index');

        // Alternative URL
        Route::post('getPBBService', 'index');
        Route::get('getPBBService', 'index');
    });
});
