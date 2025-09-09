<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CircuitController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Circuits
Route::get('/circuits', [CircuitController::class, 'index'])->name('circuits.index');
Route::get('/circuits/{slug}', [CircuitController::class, 'show'])->name('circuits.show');
Route::post('/circuits/{slug}/review', [CircuitController::class, 'submitReview'])->name('circuits.review');
Route::post('/circuits/{slug}/reservation', [ReservationController::class, 'store'])->name('reservations.store');
Route::post('/circuits/{slug}/reserve', [ReservationController::class, 'store'])->name('circuits.reserve');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{slug}/comment', [BlogController::class, 'submitComment'])->name('blog.comment');
Route::get('/blog/tag/{slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');

// Galerie
Route::get('/galerie', [\App\Http\Controllers\GalerieController::class, 'index'])->name('galerie.index');
Route::get('/galerie/{gallery}', [\App\Http\Controllers\GalerieController::class, 'show'])->name('galerie.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{gallery}', [GalleryController::class, 'show'])->name('gallery.show');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// À propos
Route::get('/a-propos', [AboutController::class, 'index'])->name('about.index');

// Destinations
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');

// Réservations
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/reservations/{reference}', [ReservationController::class, 'show'])->name('reservations.show');
Route::get('/reservations/{reference}/confirmation', [ReservationController::class, 'confirmation'])->name('reservations.confirmation');
Route::post('/reservations/{reference}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

// Authentification
// Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
// });

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Offline page
Route::get('/offline', function () {
    return View::make('offline');
})->name('offline');

// Note: les routes admin sont définies dans routes/admin.php.
require base_path('routes/admin.php');

