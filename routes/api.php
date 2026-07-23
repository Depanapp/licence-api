<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicenseController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API fonctionne',
        'status' => true
    ]);
});

Route::post('/license/check', [LicenseController::class, 'check']);