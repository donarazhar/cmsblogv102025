<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\DonationTransactionController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TestimonialController;
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

        // Posts Routes
        Route::resource('posts', PostController::class);
        Route::post('posts/{post}/toggle-featured', [PostController::class, 'toggleFeatured'])
            ->name('posts.toggle-featured');
        Route::post('posts/{post}/publish', [PostController::class, 'publish'])
            ->name('posts.publish');
        Route::post('posts/{post}/unpublish', [PostController::class, 'unpublish'])
            ->name('posts.unpublish');
        Route::delete('posts/{post}/remove-image', [PostController::class, 'removeImage'])
            ->name('posts.remove-image');

        // Categories routes
        Route::resource('categories', CategoryController::class);
        Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::get('categories/{category}/remove-image', [CategoryController::class, 'removeImage'])->name('categories.remove-image');
        Route::post('categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');

        //  Tags Routes
        Route::resource('tags', TagController::class);
        Route::delete('tags/bulk-delete', [TagController::class, 'bulkDelete'])
            ->name('tags.bulk-delete');

        // Comments Routes
        Route::resource('comments', CommentController::class)
            ->except(['create', 'store']);

        // Comment Actions
        Route::post('comments/{comment}/approve', [CommentController::class, 'approve'])
            ->name('comments.approve');
        Route::post('comments/{comment}/spam', [CommentController::class, 'spam'])
            ->name('comments.spam');
        Route::post('comments/{comment}/trash', [CommentController::class, 'trash'])
            ->name('comments.trash');
        Route::post('comments/{comment}/reply', [CommentController::class, 'reply'])
            ->name('comments.reply');

        // Bulk Actions
        Route::post('comments/bulk-action', [CommentController::class, 'bulkAction'])
            ->name('comments.bulk-action');

        // Staff Routes
        Route::resource('staff', StaffController::class);
        Route::delete('staff/bulk-delete', [StaffController::class, 'bulkDelete'])
            ->name('staff.bulk-delete');
        Route::post('staff/update-order', [StaffController::class, 'updateOrder'])
            ->name('staff.update-order');
        Route::get('staff/{staff}/remove-photo', [StaffController::class, 'removePhoto'])->name('staff.remove-photo');

        // Testimonials
        Route::resource('testimonials', TestimonialController::class);
        Route::post('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])
            ->name('testimonials.approve');
        Route::post('testimonials/{testimonial}/reject', [TestimonialController::class, 'reject'])
            ->name('testimonials.reject');

        // Sliders CRUD
        Route::resource('sliders', SliderController::class);
        Route::post('sliders/{slider}/toggle', [SliderController::class, 'toggleStatus'])->name('sliders.toggle');
        Route::post('sliders/update-order', [SliderController::class, 'updateOrder'])->name('sliders.update-order');

        // Pages Routes
        Route::resource('pages', PageController::class);
        Route::post('pages/reorder', [PageController::class, 'reorder'])
            ->name('pages.reorder');
        Route::delete('pages/{page}/remove-image', [PageController::class, 'removeImage'])
            ->name('pages.remove-image');

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

        // Schedules Routes
        Route::resource('schedules', ScheduleController::class);
        Route::post('schedules/{schedule}/toggle-active', [ScheduleController::class, 'toggleActive'])
            ->name('schedules.toggle-active');

        // Announcements Routes
        Route::resource('announcements', AnnouncementController::class);
        Route::post('announcements/{announcement}/toggle-active', [AnnouncementController::class, 'toggleActive'])
            ->name('announcements.toggle-active');
        Route::post('announcements/reorder', [AnnouncementController::class, 'reorder'])
            ->name('announcements.reorder');


        // Donation Routes
        Route::resource('donations', DonationController::class);
        Route::post('donations/{donation}/toggle-active', [DonationController::class, 'toggleActive'])
            ->name('donations.toggle-active');
        Route::post('donations/{donation}/toggle-featured', [DonationController::class, 'toggleFeatured'])
            ->name('donations.toggle-featured');

        // Donation Transaction Routes
        Route::resource('donation-transactions', DonationTransactionController::class);
        Route::post('donation-transactions/{donationTransaction}/verify', [DonationTransactionController::class, 'verify'])
            ->name('donation-transactions.verify');
        Route::post('donation-transactions/{donationTransaction}/reject', [DonationTransactionController::class, 'reject'])
            ->name('donation-transactions.reject');
        Route::post('donation-transactions/bulk-verify', [DonationTransactionController::class, 'bulkVerify'])
            ->name('donation-transactions.bulk-verify');
        Route::get('donation-transactions-export', [DonationTransactionController::class, 'export'])
            ->name('donation-transactions.export');

        // Contacts Routes
        Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);
        Route::post('contacts/{contact}/reply', [ContactController::class, 'reply'])
            ->name('contacts.reply');
        Route::post('contacts/{contact}/archive', [ContactController::class, 'archive'])
            ->name('contacts.archive');
        Route::post('contacts/bulk-action', [ContactController::class, 'bulkAction'])
            ->name('contacts.bulk-action');
        Route::get('contacts/export/csv', [ContactController::class, 'exportCsv'])
            ->name('contacts.export-csv');

        // Activity Logs Routes (sudah ada di response sebelumnya)
        Route::prefix('activity-logs')->name('activity-logs.')->group(function () {
            Route::get('/', [ActivityLogController::class, 'index'])->name('index');
            Route::get('/analytics', [ActivityLogController::class, 'analytics'])->name('analytics');
            Route::get('/{activity}/show', [ActivityLogController::class, 'show'])->name('show'); // Tambahkan ini
            Route::get('/user/{user}', [ActivityLogController::class, 'userActivity'])->name('user-activity');
            Route::delete('/{activity}', [ActivityLogController::class, 'destroy'])->name('destroy');
            Route::post('/clear', [ActivityLogController::class, 'clear'])->name('clear');
        });
    });
});
