<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\LandingController;

/*
|--------------------------------------------------------------------------
| Public Routes - Landing Page
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [LandingController::class, 'index'])->name('home');

// About
Route::get('/about', [LandingController::class, 'about'])->name('about');

// Programs
Route::get('/programs', [LandingController::class, 'programs'])->name('programs');
Route::get('/program/{slug}', [LandingController::class, 'programDetail'])->name('program.detail');

// Blog/News
Route::get('/blog', [LandingController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [LandingController::class, 'blogDetail'])->name('blog.detail');

// Gallery
Route::get('/gallery', [LandingController::class, 'gallery'])->name('gallery');
Route::get('/gallery/{slug}', [LandingController::class, 'galleryAlbum'])->name('gallery.album');

// Donations
Route::get('/donations', [LandingController::class, 'donations'])->name('donations');
Route::get('/donation/{slug}', [LandingController::class, 'donationDetail'])->name('donations.show');

// Contact
Route::get('/contact', [LandingController::class, 'contact'])->name('contact');
Route::post('/contact', [LandingController::class, 'contactSubmit'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // TODO: Add more admin routes here
        // Route::resource('posts', PostController::class);
        // Route::resource('categories', CategoryController::class);
        // etc...
    });
});