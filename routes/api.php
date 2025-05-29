<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CalendarEventController;
use App\Http\Controllers\DiaryEntryController;
use App\Http\Controllers\ProfileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

// Rutas para Tags
Route::prefix('tags')->middleware('auth:api')->group(function () {
    Route::get('/', [TagController::class, 'index']);
    Route::post('/', [TagController::class, 'store']);
    Route::put('/{id}', [TagController::class, 'update']);
    Route::delete('/{id}', [TagController::class, 'destroy']);
});

// Rutas para Activities
Route::prefix('activities')->middleware('auth:api')->group(function () {
    Route::get('/', [ActivityController::class, 'index']);
    Route::post('/', [ActivityController::class, 'store']);
    Route::put('/{id}', [ActivityController::class, 'update']);
    Route::delete('/{id}', [ActivityController::class, 'destroy']);
});

Route::prefix('calendar-events')->middleware('auth:api')->group(function () {
    Route::get('/', [CalendarEventController::class, 'index']);
    Route::post('/', [CalendarEventController::class, 'store']);
    Route::put('/{id}', [CalendarEventController::class, 'update']);
    Route::delete('/{id}', [CalendarEventController::class, 'destroy']);
    Route::get('/activity/{activityId}', [CalendarEventController::class, 'getEventsByActivity']);
});

// Rutas para DiaryEntries
Route::prefix('diary-entries')->middleware('auth:api')->group(function () {
    Route::get('/', [DiaryEntryController::class, 'index']);
    Route::post('/', [DiaryEntryController::class, 'store']);
    Route::get('/{id}', [DiaryEntryController::class, 'show']);
    Route::put('/{id}', [DiaryEntryController::class, 'update']);
    Route::delete('/{id}', [DiaryEntryController::class, 'destroy']);
    Route::get('/date-range', [DiaryEntryController::class, 'getByDateRange']);
    Route::get('/diary-entries/default-colors', [DiaryEntryController::class, 'getDefaultColors']);
});

// Rutas para el perfil
Route::prefix('profile')->middleware('auth:api')->group(function () {
    Route::get('/', [ProfileController::class, 'show']);
    Route::put('/', [ProfileController::class, 'update']);
    Route::get('/stats', [ProfileController::class, 'getStats']);
});
