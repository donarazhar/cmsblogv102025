<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PostController;

use App\Http\Controllers\Api\ProgramController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Posts/Berita API Routes
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slug}', [PostController::class, 'show']);

// Layanan/Programs API Routes
Route::get('/programs', [ProgramController::class, 'index']);
Route::get('/programs/{slug}', [ProgramController::class, 'show']);

// YouTube API Routes
Route::get('/youtube', [\App\Http\Controllers\Api\YoutubeController::class, 'index']);

// Slider/Hero Banner API Routes
Route::get('/sliders', [\App\Http\Controllers\Api\SliderController::class, 'index']);
