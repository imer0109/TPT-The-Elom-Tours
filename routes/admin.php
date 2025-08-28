<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
|
*/

// Route de test sans authentification
Route::get('/test', function() {
    return 'Route admin de test fonctionne';
});

Route::middleware(['web', 'auth'])->group(function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Réservations
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReservationController::class, 'index'])->name('index');
        Route::get('/dashboard', [\App\Http\Controllers\Admin\ReservationController::class, 'dashboard'])->name('dashboard');
        Route::get('/create', [\App\Http\Controllers\Admin\ReservationController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\ReservationController::class, 'store'])->name('store');
        Route::get('/{reservation}', [\App\Http\Controllers\Admin\ReservationController::class, 'show'])->name('show');
        Route::get('/{reservation}/edit', [\App\Http\Controllers\Admin\ReservationController::class, 'edit'])->name('edit');
        Route::put('/{reservation}', [\App\Http\Controllers\Admin\ReservationController::class, 'update'])->name('update');
        Route::delete('/{reservation}', [\App\Http\Controllers\Admin\ReservationController::class, 'destroy'])->name('destroy');
        Route::patch('/{reservation}/change-status', [\App\Http\Controllers\Admin\ReservationController::class, 'changeStatus'])->name('change-status');
    });
    
    // Circuits
    Route::prefix('circuits')->name('circuits.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CircuitController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\CircuitController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\CircuitController::class, 'store'])->name('store');
        Route::get('/{circuit}', [\App\Http\Controllers\Admin\CircuitController::class, 'show'])->name('show');
        Route::get('/{circuit}/edit', [\App\Http\Controllers\Admin\CircuitController::class, 'edit'])->name('edit');
        Route::put('/{circuit}', [\App\Http\Controllers\Admin\CircuitController::class, 'update'])->name('update');
        Route::delete('/{circuit}', [\App\Http\Controllers\Admin\CircuitController::class, 'destroy'])->name('destroy');
        Route::patch('/{circuit}/toggle-active', [\App\Http\Controllers\Admin\CircuitController::class, 'toggleActive'])->name('toggle-active');
    });
    
    // Destinations
    Route::prefix('destinations')->name('destinations.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DestinationController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\DestinationController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\DestinationController::class, 'store'])->name('store');
        Route::get('/{destination}/edit', [\App\Http\Controllers\Admin\DestinationController::class, 'edit'])->name('edit');
        Route::put('/{destination}', [\App\Http\Controllers\Admin\DestinationController::class, 'update'])->name('update');
        Route::delete('/{destination}', [\App\Http\Controllers\Admin\DestinationController::class, 'destroy'])->name('destroy');
        Route::patch('/{destination}/toggle-active', [\App\Http\Controllers\Admin\DestinationController::class, 'toggleActive'])->name('toggle-active');
        Route::patch('/{destination}/toggle-popular', [\App\Http\Controllers\Admin\DestinationController::class, 'togglePopular'])->name('toggle-popular');
    });
    
    // Clients
    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ClientController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\ClientController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\ClientController::class, 'store'])->name('store');
        Route::get('/{client}', [\App\Http\Controllers\Admin\ClientController::class, 'show'])->name('show');
        Route::get('/{client}/edit', [\App\Http\Controllers\Admin\ClientController::class, 'edit'])->name('edit');
        Route::put('/{client}', [\App\Http\Controllers\Admin\ClientController::class, 'update'])->name('update');
        Route::delete('/{client}', [\App\Http\Controllers\Admin\ClientController::class, 'destroy'])->name('destroy');
    });
    
    // Blog
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\BlogPostController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\BlogPostController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\BlogPostController::class, 'store'])->name('store');
        Route::get('/{blogPost}', [\App\Http\Controllers\Admin\BlogPostController::class, 'show'])->name('show');
        Route::get('/{blogPost}/edit', [\App\Http\Controllers\Admin\BlogPostController::class, 'edit'])->name('edit');
        Route::put('/{blogPost}', [\App\Http\Controllers\Admin\BlogPostController::class, 'update'])->name('update');
        Route::delete('/{blogPost}', [\App\Http\Controllers\Admin\BlogPostController::class, 'destroy'])->name('destroy');
        Route::patch('/{blogPost}/toggle-active', [\App\Http\Controllers\Admin\BlogPostController::class, 'toggleActive'])->name('toggle-active');
        Route::patch('/{blogPost}/toggle-featured', [\App\Http\Controllers\Admin\BlogPostController::class, 'toggleFeatured'])->name('toggle-featured');
    });
    
    // Galerie
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\GalleryController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\GalleryController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('store');
        Route::get('/{gallery}', [\App\Http\Controllers\Admin\GalleryController::class, 'show'])->name('show');
        Route::get('/{gallery}/edit', [\App\Http\Controllers\Admin\GalleryController::class, 'edit'])->name('edit');
        Route::put('/{gallery}', [\App\Http\Controllers\Admin\GalleryController::class, 'update'])->name('update');
        Route::delete('/{gallery}', [\App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->name('destroy');
        Route::patch('/{gallery}/toggle-active', [\App\Http\Controllers\Admin\GalleryController::class, 'toggleActive'])->name('toggle-active');
        Route::post('/reorder', [\App\Http\Controllers\Admin\GalleryController::class, 'reorder'])->name('reorder');
    });
    
    // Messages
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('index');
        Route::get('/{message}', [\App\Http\Controllers\Admin\MessageController::class, 'show'])->name('show');
        Route::delete('/{message}', [\App\Http\Controllers\Admin\MessageController::class, 'destroy'])->name('destroy');
        Route::patch('/{message}/toggle-read', [\App\Http\Controllers\Admin\MessageController::class, 'toggleRead'])->name('toggle-read');
        Route::patch('/{message}/toggle-archived', [\App\Http\Controllers\Admin\MessageController::class, 'toggleArchived'])->name('toggle-archived');
        Route::post('/{message}/reply', [\App\Http\Controllers\Admin\MessageController::class, 'reply'])->name('reply');
        Route::post('/bulk-action', [\App\Http\Controllers\Admin\MessageController::class, 'bulkAction'])->name('bulk-action');
    });
    
    // Avis
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('index');
        Route::get('/{review}/edit', [\App\Http\Controllers\Admin\ReviewController::class, 'edit'])->name('edit');
        Route::put('/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'update'])->name('update');
        Route::patch('/{review}/approve', [\App\Http\Controllers\Admin\ReviewController::class, 'toggleApproval'])->name('approve');
        Route::patch('/{review}/disapprove', [\App\Http\Controllers\Admin\ReviewController::class, 'toggleApproval'])->name('disapprove')->defaults('approve', false);
        Route::delete('/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('destroy');
    });
    
    // Paramètres
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('index');
        Route::post('/general', [\App\Http\Controllers\Admin\SettingsController::class, 'updateGeneral'])->name('update.general');
        Route::post('/company', [\App\Http\Controllers\Admin\SettingsController::class, 'updateCompany'])->name('update.company');
        Route::post('/seo', [\App\Http\Controllers\Admin\SettingsController::class, 'updateSeo'])->name('update.seo');
        Route::post('/social', [\App\Http\Controllers\Admin\SettingsController::class, 'updateSocial'])->name('update.social');
        Route::post('/email', [\App\Http\Controllers\Admin\SettingsController::class, 'updateEmail'])->name('update.email');
        Route::post('/api', [\App\Http\Controllers\Admin\SettingsController::class, 'updateApi'])->name('update.api');
        Route::post('/generate-sitemap', [\App\Http\Controllers\Admin\SettingsController::class, 'generateSitemap'])->name('generate.sitemap');
        Route::post('/send-test-email', [\App\Http\Controllers\Admin\SettingsController::class, 'sendTestEmail'])->name('send.test.email');
        Route::post('/generate-api-key', [\App\Http\Controllers\Admin\SettingsController::class, 'generateApiKey'])->name('generate.api.key');
        Route::post('/generate-api-secret', [\App\Http\Controllers\Admin\SettingsController::class, 'generateApiSecret'])->name('generate.api.secret');
    });
});