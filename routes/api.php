<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Master Data API Endpoints
Route::middleware('auth:sanctum')->get('/master-data/items', [\App\Http\Controllers\MasterDataController::class, 'getItems']);
Route::middleware('auth:sanctum')->get('/master-data/categories', [\App\Http\Controllers\MasterDataController::class, 'getCategories']);
Route::middleware('auth:sanctum')->get('/master-data/units', [\App\Http\Controllers\MasterDataController::class, 'getUnits']);
Route::middleware('auth:sanctum')->get('/master-data/locations', [\App\Http\Controllers\MasterDataController::class, 'getLocations']);
Route::middleware('auth:sanctum')->get('/master-data/suppliers', [\App\Http\Controllers\MasterDataController::class, 'getSuppliers']);
Route::middleware('auth:sanctum')->get('/master-data/divisions', [\App\Http\Controllers\MasterDataController::class, 'getDivisions']);

// Device Session API Endpoints
Route::middleware('auth:sanctum')->get('/sessions', [\App\Http\Controllers\SessionController::class, 'index']);
Route::middleware('auth:sanctum')->delete('/sessions/{id}', [\App\Http\Controllers\SessionController::class, 'destroy']);
Route::middleware('auth:sanctum')->delete('/sessions', [\App\Http\Controllers\SessionController::class, 'destroyAll']);
Route::middleware('auth:sanctum')->post('/sessions/{id}/revoke', [\App\Http\Controllers\SessionController::class, 'revoke']);
Route::middleware('auth:sanctum')->post('/sessions/revoke-all', [\App\Http\Controllers\SessionController::class, 'revokeAll']);
Route::middleware('auth:sanctum')->post('/sessions/logout-other', [\App\Http\Controllers\SessionController::class, 'logoutOther']);
