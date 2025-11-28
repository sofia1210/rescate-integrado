<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReportApiController;
use App\Http\Controllers\Api\AnimalFileApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\AnimalCareApiController;
use App\Http\Controllers\Api\AnimalFeedingApiController;
use App\Http\Controllers\Api\AnimalMedicalEvaluationApiController;
use App\Http\Controllers\Api\AnimalHistoryApiController;
use App\Http\Controllers\Api\TransferApiController;
use App\Http\Controllers\Api\ReleaseApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::name('api.')->group(function () {
    Route::apiResource('login', AuthApiController::class)->only(['store']);
    Route::apiResource('reports', ReportApiController::class);
    Route::apiResource('animal-files', AnimalFileApiController::class)->only(['index', 'show', 'store']);
    Route::apiResource('animal-cares', AnimalCareApiController::class)->only(['index', 'show', 'store']);
    Route::apiResource('animal-feedings', AnimalFeedingApiController::class)->only(['index', 'show', 'store']);
    Route::apiResource('animal-medical-evaluations', AnimalMedicalEvaluationApiController::class)->only(['index', 'show', 'store']);
    Route::apiResource('animal-histories', AnimalHistoryApiController::class)->only(['index', 'show', 'store']);
    Route::apiResource('transfers', TransferApiController::class)->only(['index', 'show', 'store']);
    Route::apiResource('releases', ReleaseApiController::class)->only(['index', 'show', 'store']);
    Route::apiResource('users', UserApiController::class);
});
