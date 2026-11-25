<?php

use App\Http\Controllers\BandAPIController;
use App\Http\Controllers\AlbumAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('bands', BandAPIController::class)->names('api.bands')->only(['index', 'show']);
Route::apiResource('albums', AlbumAPIController::class)->names('api.albums')->only(['index', 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('bands', BandAPIController::class)->names('api.bands')->only(['update']);
    Route::apiResource('albums', AlbumAPIController::class)->names('api.albums')->only(['update']);
    Route::middleware('admin')->group(function () {
        Route::apiResource('bands', BandAPIController::class)->names('api.bands')->only(['store', 'destroy']);
        Route::apiResource('albums', AlbumAPIController::class)->names('api.albums')->only(['store', 'destroy']);
    });
});
