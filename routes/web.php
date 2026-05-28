<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\DonationTransactionController;

use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProgramController;

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| SEO Routes (Harus paling atas)
|--------------------------------------------------------------------------
*/

Route::get('sitemap.xml', [SitemapController::class, 'index']);
Route::get('robots.txt', [RobotsController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Public Routes - Landing Page
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [LandingController::class, 'index'])->name('home');

// Profile
Route::get('/profil/sejarah', [LandingController::class, 'profileSejarah'])->name('frontend.profile.sejarah');
Route::get('/profil/visi-misi', [LandingController::class, 'profileVisiMisi'])->name('frontend.profile.visi-misi');
Route::get('/profil/struktur-organisasi', [LandingController::class, 'profileStruktur'])->name('frontend.profile.struktur-organisasi');
Route::get('/profil/pengurus-staf', [LandingController::class, 'profilePengurusStaf'])->name('frontend.profile.pengurus-staf');
Route::get('/profil/fasilitas', [LandingController::class, 'profileFasilitas'])->name('frontend.profile.fasilitas');

// Programs
Route::get('/programs', [LandingController::class, 'programs'])->name('programs');
Route::get('/program/{slug}', [LandingController::class, 'programDetail'])->name('program.detail');

// Blog/News
Route::get('/blog', [LandingController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [LandingController::class, 'blogDetail'])->name('blog.detail');
// Route untuk submit comment
Route::post('/blog/{slug}/comment', [LandingController::class, 'blogCommentSubmit'])->name('blog.comment.submit');


// Donations
Route::get('/donations', [LandingController::class, 'donations'])->name('donations');
Route::get('/donation/{slug}', [LandingController::class, 'donationDetail'])->name('donations.show');

// Contact
Route::get('/contact', [LandingController::class, 'contact'])->name('contact');
Route::post('/contact', [LandingController::class, 'contactSubmit'])->name('contact.submit');

// Search (required for Google Sitelinks SearchAction schema)
Route::get('/search', [LandingController::class, 'search'])->name('search');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest Only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');

    // Register dinonaktifkan untuk keamanan — hanya admin yang bisa membuat akun baru
    // Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    // Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Logged In Users Only)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ✅ CACHE CLEAR ROUTE - ADD THIS
        Route::post('/cache/clear', function () {
            try {
                // Clear all caches
                Cache::flush();
                Artisan::call('cache:clear');
                Artisan::call('view:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear');

                return back()->with('success', 'Cache berhasil dibersihkan! Perubahan akan terlihat di landing page.');
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal membersihkan cache: ' . $e->getMessage());
            }
        })->name('cache.clear');

        // Posts Routes
        Route::resource('posts', PostController::class);
        Route::post('posts/{post}/toggle-featured', [PostController::class, 'toggleFeatured'])
            ->name('posts.toggle-featured');
        Route::post('posts/{post}/publish', [PostController::class, 'publish'])
            ->name('posts.publish');
        Route::post('posts/{post}/unpublish', [PostController::class, 'unpublish'])
            ->name('posts.unpublish');
        Route::post('posts/upload-image', [PostController::class, 'uploadImage'])
            ->name('posts.upload-image');
        Route::delete('posts/{post}/remove-image', [PostController::class, 'removeImage'])
            ->name('posts.remove-image');

        // Categories Routes
        Route::resource('categories', CategoryController::class);
        Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
            ->name('categories.toggle-status');
        Route::get('categories/{category}/remove-image', [CategoryController::class, 'removeImage'])
            ->name('categories.remove-image');
        Route::post('categories/reorder', [CategoryController::class, 'reorder'])
            ->name('categories.reorder');

        // Tags Routes
        Route::resource('tags', TagController::class);
        Route::delete('tags/bulk-delete', [TagController::class, 'bulkDelete'])
            ->name('tags.bulk-delete');

        // Comments Routes
        Route::resource('comments', CommentController::class)->except(['create', 'store']);
        Route::post('comments/{comment}/approve', [CommentController::class, 'approve'])
            ->name('comments.approve');
        Route::post('comments/{comment}/spam', [CommentController::class, 'spam'])
            ->name('comments.spam');
        Route::post('comments/{comment}/trash', [CommentController::class, 'trash'])
            ->name('comments.trash');
        Route::post('comments/{comment}/reply', [CommentController::class, 'reply'])
            ->name('comments.reply');
        Route::post('comments/bulk-action', [CommentController::class, 'bulkAction'])
            ->name('comments.bulk-action');

        // Staff Routes
        Route::resource('staff', StaffController::class);
        Route::delete('staff/bulk-delete', [StaffController::class, 'bulkDelete'])
            ->name('staff.bulk-delete');
        Route::post('staff/update-order', [StaffController::class, 'updateOrder'])
            ->name('staff.update-order');
        Route::get('staff/{staff}/remove-photo', [StaffController::class, 'removePhoto'])
            ->name('staff.remove-photo');

        // Testimonials Routes
        Route::resource('testimonials', TestimonialController::class);
        Route::post('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])
            ->name('testimonials.approve');
        Route::post('testimonials/{testimonial}/reject', [TestimonialController::class, 'reject'])
            ->name('testimonials.reject');

        // Sliders Routes
        Route::resource('sliders', SliderController::class);
        Route::post('sliders/{slider}/toggle', [SliderController::class, 'toggleStatus'])
            ->name('sliders.toggle');
        Route::post('sliders/update-order', [SliderController::class, 'updateOrder'])
            ->name('sliders.update-order');

        // Popup Ads Routes
        Route::resource('popup-ads', \App\Http\Controllers\Admin\PopupAdController::class);
        Route::post('popup-ads/{popupAd}/toggle', [\App\Http\Controllers\Admin\PopupAdController::class, 'toggleStatus'])
            ->name('popup-ads.toggle');

        // Ad Banners Routes
        Route::resource('ad-banners', \App\Http\Controllers\Admin\AdBannerController::class);

        // Social Embeds Routes
        Route::get('social-embeds', [\App\Http\Controllers\Admin\SocialEmbedController::class, 'index'])->name('social-embeds.index');
        Route::post('social-embeds', [\App\Http\Controllers\Admin\SocialEmbedController::class, 'update'])->name('social-embeds.update');
        Route::post('ad-banners/{adBanner}/toggle', [\App\Http\Controllers\Admin\AdBannerController::class, 'toggleStatus'])
            ->name('ad-banners.toggle');
        Route::post('ad-banners/update-order', [\App\Http\Controllers\Admin\AdBannerController::class, 'updateOrder'])
            ->name('ad-banners.update-order');

        // Pages Routes
        Route::resource('pages', PageController::class);
        Route::post('pages/reorder', [PageController::class, 'reorder'])
            ->name('pages.reorder');
        Route::delete('pages/{page}/remove-image', [PageController::class, 'removeImage'])
            ->name('pages.remove-image');

        // Programs Routes
        Route::resource('programs', ProgramController::class);
        Route::post('programs/{program}/toggle', [ProgramController::class, 'toggleStatus'])
            ->name('programs.toggle');
        Route::post('programs/{program}/toggle-featured', [ProgramController::class, 'toggleFeatured'])
            ->name('programs.toggle-featured');
        Route::post('programs/upload-image', [ProgramController::class, 'uploadImage'])
            ->name('programs.upload-image');


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

        // Donation Transactions Routes
        Route::resource('donation-transactions', DonationTransactionController::class);
        Route::post('donation-transactions/{donationTransaction}/verify', [DonationTransactionController::class, 'verify'])
            ->name('donation-transactions.verify');
        Route::post('donation-transactions/{donationTransaction}/reject', [DonationTransactionController::class, 'reject'])
            ->name('donation-transactions.reject');
        Route::post('donation-transactions/bulk-verify', [DonationTransactionController::class, 'bulkVerify'])
            ->name('donation-transactions.bulk-verify');
        Route::get('donation-transactions/export', [DonationTransactionController::class, 'export'])
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


        // Profile Routes
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::get('/sejarah', [ProfileController::class, 'sejarah'])->name('sejarah');
            Route::put('/sejarah', [ProfileController::class, 'updateSejarah'])->name('sejarah.update');
            Route::get('/visi-misi', [ProfileController::class, 'visiMisi'])->name('visi-misi');
            Route::put('/visi-misi', [ProfileController::class, 'updateVisiMisi'])->name('visi-misi.update');
            Route::get('/struktur-organisasi', [ProfileController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
            Route::put('/struktur-organisasi', [ProfileController::class, 'updateStrukturOrganisasi'])->name('struktur-organisasi.update');
            Route::get('/fasilitas', [ProfileController::class, 'fasilitas'])->name('fasilitas');
            Route::put('/fasilitas', [ProfileController::class, 'updateFasilitas'])->name('fasilitas.update');
        });

        // My Account (accessible by all roles)
        Route::get('my-account', [UserController::class, 'editSelf'])->name('my-account');
        Route::put('my-account', [UserController::class, 'updateSelf'])->name('my-account.update');

        // === Admin Only Routes (Settings, Users, Logs, Backups) ===
        Route::middleware('admin.only')->group(function () {
            // Activity Logs Routes
            Route::prefix('activity-logs')->name('activity-logs.')->group(function () {
                Route::get('/', [ActivityLogController::class, 'index'])->name('index');
                Route::get('/analytics', [ActivityLogController::class, 'analytics'])->name('analytics');
                Route::get('/{activity}/show', [ActivityLogController::class, 'show'])->name('show');
                Route::get('/user/{user}', [ActivityLogController::class, 'userActivity'])->name('user-activity');
                Route::delete('/{activity}', [ActivityLogController::class, 'destroy'])->name('destroy');
                Route::post('/clear', [ActivityLogController::class, 'clear'])->name('clear');
            });

            // Backup Routes
            Route::prefix('backups')->name('backups.')->group(function () {
                Route::get('/', [BackupController::class, 'index'])->name('index');
                Route::post('/create', [BackupController::class, 'create'])->name('create');
                Route::post('/create-full', [BackupController::class, 'createFull'])->name('create-full');
                Route::get('/download/{filename}', [BackupController::class, 'download'])->name('download');
                Route::delete('/{filename}', [BackupController::class, 'destroy'])->name('destroy');
                Route::post('/clean', [BackupController::class, 'clean'])->name('clean');
                Route::post('/restore', [BackupController::class, 'restore'])->name('restore');
            });

            // Settings Routes
            Route::prefix('settings')->name('settings.')->group(function () {
                Route::get('/', [SettingController::class, 'index'])->name('index');
                Route::post('/', [SettingController::class, 'update'])->name('update');
                Route::get('/create', [SettingController::class, 'create'])->name('create');
                Route::post('/store', [SettingController::class, 'store'])->name('store');
                Route::delete('/{setting}', [SettingController::class, 'destroy'])->name('destroy');
                Route::post('/clear-cache', [SettingController::class, 'clearCache'])->name('clear-cache');
            });

            // User Management Routes
            Route::resource('users', UserController::class);
            Route::get('users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.change-password');
            Route::put('users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Fallback Route (MUST BE LAST)
|--------------------------------------------------------------------------
| Redirect any undefined URL back to the home page
*/
Route::fallback(function () {
    return redirect()->route('home');
});
