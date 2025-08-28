<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CircuitController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalerieController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DestinationController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\CategorieController;

use Illuminate\Support\Facades\View;

// Route d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes pour les circuits
Route::get('/circuits', [CircuitController::class, 'index'])->name('circuits.index');
Route::get('/circuits/{slug}', [CircuitController::class, 'show'])->name('circuits.show');
Route::post('/circuits/{slug}/review', [CircuitController::class, 'submitReview'])->name('circuits.review');
Route::post('/circuits/{slug}/reservation', [\App\Http\Controllers\ReservationController::class, 'store'])->name('reservations.store');

// Routes pour le blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Route pour la galerie
Route::get('/galerie', [GalerieController::class, 'index'])->name('galerie.index');

// Route pour la page contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Route pour la page à propos
Route::get('/a-propos', [AboutController::class, 'index'])->name('about.index');

// Routes d'authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Routes pour les réservations
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/reservations/{reference}', [ReservationController::class, 'show'])->name('reservations.show');
Route::get('/reservations/{reference}/confirmation', [ReservationController::class, 'confirmation'])->name('reservations.confirmation');
Route::post('/reservations/{reference}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

// Route pour la page 404 (sera automatiquement gérée par Laravel)

// Route pour la page hors ligne (offline)
Route::get('/offline', function () {
    return View::make('offline');
})->name('offline');

    

// Routes pour le dashboard (administration)
// Route de test sans authentification
Route::get('/admin/test', function() {
    return 'Route admin de test fonctionne';
});

// Route::prefix('admin')->middleware(['web', 'auth'])->name('admin.')->group(function () {
Route::prefix('admin')->name('admin.')->group(function () {
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
    
    // Catégories
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CategorieController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\CategorieController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\CategorieController::class, 'store'])->name('store');
        Route::get('/{category}', [\App\Http\Controllers\Admin\CategorieController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [\App\Http\Controllers\Admin\CategorieController::class, 'edit'])->name('edit');
        Route::put('/{category}', [\App\Http\Controllers\Admin\CategorieController::class, 'update'])->name('update');
        Route::delete('/{category}', [\App\Http\Controllers\Admin\CategorieController::class, 'destroy'])->name('destroy');
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

// Routes pour les destinations
Route::get('/destinations', [\App\Http\Controllers\DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [\App\Http\Controllers\DestinationController::class, 'show'])->name('destinations.show');

