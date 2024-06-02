<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\QRCodeController;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::post('/', [RestaurantController::class, 'search'])->name('restaurants.search');

Route::get('/a', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('index');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/restaurants/{restaurantId}', [RestaurantController::class, 'show'])->name('restaurants.show');
Route::post('/restaurants/{restaurantId}/add', [FavoriteController::class, 'addFavorite'])->name('favorite.store')->middleware(['auth', 'verified']);
Route::delete('/restaurants/{restaurantId}/delete', [FavoriteController::class, 'deleteFavorite'])->name('favorite.destroy')->middleware(['auth', 'verified']);

Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index')->middleware(['auth', 'verified']);
Route::post('/mypage/{restaurantId}/add', [MypageController::class, 'addFavorite'])->name('mypage.favorites.store')->middleware(['auth', 'verified']);
Route::delete('/mypage/{restaurantId}/delete', [MypageController::class, 'deleteFavorite'])->name('mypage.favorites.destroy')->middleware(['auth', 'verified']);

Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store')->middleware(['auth', 'verified']);
Route::post('/reservations/{reservationId}/edit', [ReservationController::class, 'update'])->name('reservations.update')->middleware(['auth', 'verified']);
Route::delete('/reservations/{reservationId}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel')->middleware(['auth', 'verified']);
Route::put('/reservations/{reservationId}/restore', [ReservationController::class, 'restore'])->name('reservations.restore')->middleware(['auth', 'verified']);

Route::get('/reservations/{reservationId}', [QRCodeController::class, 'generateQRCode'])->name('reservations.qrcode')->middleware(['auth', 'verified']);
Route::get('/reservations/{reservationId}/read', [QRCodeController::class, 'readQRCode'])->name('authentication.reading');

Route::get('/success', function () {
    return view('auth.success');
})->name('success');

Route::get('/errors', function() {
    return view('auth.errors');
})->name('errors');


require __DIR__ . '/auth.php';
