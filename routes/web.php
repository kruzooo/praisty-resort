<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestAuthController;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/guest-login', [GuestAuthController::class, 'create'])->name('guest.login');
Route::post('/guest-login', [GuestAuthController::class, 'store'])->name('guest.login.store');
Route::get('/forgot-password', [GuestAuthController::class, 'forgotPassword'])->name('guest.password.request');
Route::post('/forgot-password', [GuestAuthController::class, 'resetPassword'])->name('guest.password.update');
Route::get('/create-account', [GuestAuthController::class, 'register'])->name('guest.register');
Route::post('/create-account', [GuestAuthController::class, 'registerStore'])->name('guest.register.store');
Route::post('/guest-logout', [GuestAuthController::class, 'destroy'])->name('guest.logout');
Route::get('/customer-dashboard', [HomeController::class, 'customerDashboard'])->middleware('customer')->name('customer.dashboard');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])->name('login.store');
    Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->middleware('admin')->name('dashboard');
    Route::get('/feedback', [AdminAuthController::class, 'feedback'])->middleware('admin')->name('feedback');
    Route::delete('/feedback/{feedback}', [AdminAuthController::class, 'deleteFeedback'])->middleware('admin')->name('feedback.delete');
    Route::get('/{page}', [AdminAuthController::class, 'operations'])->middleware('admin')->whereIn('page', [
        'reservations',
        'villas',
        'concierge',
        'financials',
        'new-reservation',
        'dispatch-speedboat',
        'assign-butler',
        'arrival-details',
    ])->name('operations');
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->middleware('admin')->name('logout');
});
Route::get('/rooms', [HomeController::class, 'rooms'])->name('rooms');
Route::get('/reservation-cart', [HomeController::class, 'reservationCart'])->name('reservation.cart');
Route::get('/guest-payment', [HomeController::class, 'guestPayment'])->name('reservation.guest-payment');
Route::post('/guest-payment', [HomeController::class, 'completeReservation'])->name('reservation.complete');
Route::get('/booking-confirmation', [HomeController::class, 'bookingConfirmation'])->name('reservation.confirmation');
Route::get('/rooms/{room}', [HomeController::class, 'roomDetails'])->name('rooms.details');
Route::post('/rooms/{room}/reserve', [HomeController::class, 'reserveRoom'])->middleware('customer')->name('rooms.reserve');
Route::get('/experiences', [HomeController::class, 'experiences'])->name('experiences');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [HomeController::class, 'infoPage'])->defaults('page', 'privacy')->name('privacy');
Route::get('/terms-of-service', [HomeController::class, 'infoPage'])->defaults('page', 'terms')->name('terms');
Route::get('/careers', [HomeController::class, 'infoPage'])->defaults('page', 'careers')->name('careers');
Route::get('/press-room', [HomeController::class, 'infoPage'])->defaults('page', 'press-room')->name('press-room');
Route::get('/sustainability', [HomeController::class, 'infoPage'])->defaults('page', 'sustainability')->name('sustainability');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');
Route::post('/customer-feedback', [HomeController::class, 'submitFeedback'])->middleware('customer')->name('customer.feedback');
Route::post('/generate', [HomeController::class, 'generate'])->name('generate');
