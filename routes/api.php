<?php

use App\Http\Controllers\Api\ProyectoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::name('api.')->group(function () {
    // Public API endpoints
    Route::apiResource('proyectos', ProyectoController::class)
        ->only(['index', 'show']);

    // Authenticated API endpoints (requires Sanctum token)
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('proyectos', ProyectoController::class)
            ->only(['store', 'update', 'destroy']);
    });
});
