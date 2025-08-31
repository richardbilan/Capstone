<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MapFeatureController;
use App\Http\Controllers\HazardGeometryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Note: Add authentication middleware if available (e.g., ->middleware('auth') or 'auth:sanctum')
// For now, keep public for wiring; front-end still sends CSRF if configured.

Route::get('map-features', [MapFeatureController::class, 'index']);
Route::get('map-features/{id}', [MapFeatureController::class, 'show']);
Route::post('map-features', [MapFeatureController::class, 'store']);
Route::put('map-features/{id}', [MapFeatureController::class, 'update']);
Route::delete('map-features/{id}', [MapFeatureController::class, 'destroy']);

// Hazard geometries (GeoJSON) CRUD
Route::get('hazards', [HazardGeometryController::class, 'index']);
Route::post('hazards', [HazardGeometryController::class, 'store']);
Route::put('hazards/{hazard}', [HazardGeometryController::class, 'update']);
Route::delete('hazards/{hazard}', [HazardGeometryController::class, 'destroy']);
