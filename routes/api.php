<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SyncApiAuth;
use App\Http\Controllers\Api\GenericSyncController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::post('/sync/{entity}', [GenericSyncController::class, 'handleSync'])
     ->middleware(SyncApiAuth::class);

// Endpoint lain untuk aplikasi Anda (jika ada)

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
