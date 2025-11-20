<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\SliderController;  // ✅ PASTIKAN ADA INI
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;



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

        // Sliders CRUD
        Route::resource('sliders', SliderController::class);
        Route::post('sliders/{slider}/toggle', [SliderController::class, 'toggleStatus'])->name('sliders.toggle');
        Route::post('sliders/update-order', [SliderController::class, 'updateOrder'])->name('sliders.update-order');

        // Programs
        Route::resource('programs', ProgramController::class);
        Route::post('programs/{program}/toggle', [ProgramController::class, 'toggleStatus'])->name('programs.toggle');
        Route::post('programs/{program}/toggle-featured', [ProgramController::class, 'toggleFeatured'])->name('programs.toggle-featured');

        // Gallery Albums
        Route::prefix('gallery')->name('gallery.')->group(function () {
            Route::resource('albums', GalleryAlbumController::class);
            Route::post('albums/{album}/toggle', [GalleryAlbumController::class, 'toggleStatus'])->name('albums.toggle');

            // Gallery Photos
            Route::resource('photos', GalleryController::class);
            Route::post('photos/{photo}/toggle', [GalleryController::class, 'toggleStatus'])->name('photos.toggle');
            Route::post('photos/bulk-upload', [GalleryController::class, 'bulkUpload'])->name('photos.bulk-upload');
        });
    });
});
