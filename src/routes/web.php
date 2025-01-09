<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\CustomVerifyEmailController;
use App\Http\Controllers\Auth\CustomRegisteredUserController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/', [StoreController::class, 'index'])->name('stores.index');
Route::get('/detail/{store}', [StoreController::class, 'show'])->name('store.show');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

// 会員登録処理を行うルート
Route::post('/register', [CustomRegisteredUserController::class, 'store'])
    ->middleware(['guest'])
    ->name('register');

// メール確認通知を再送信するルート
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

// メール認証リンクを処理するルート
Route::get('/email/verify/{id}/{hash}', CustomVerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::get('/thank-you', function () {
    return view('auth.thank-you');
})->name('thank-you');


// メール確認通知を再送信するルート
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware(['auth','verified'])->group(function () {
    Route::post('/detail/{store}/done', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/complete', [ReservationController::class, 'complete'])->name('reservation.complete');
    Route::get('/reservation/success/{reservation}', [ReservationController::class, 'success'])->name('reservation.success');
    Route::post('/reservation/{reservation}/cancel', [ReservationController::class, 'cancel'])
    ->name('reservation.cancel');
    Route::post('/favorites/{store}/add', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::post('/favorites/{store}/remove', [FavoriteController::class, 'remove'])->name('favorites.remove');
    Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::get('/reservations/qr/{id}', [ReservationController::class, 'showQr'])->name('reservations.qr');
    Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');
    Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/return', [PaymentController::class, 'handleReturn'])->name('payment.return');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/owners', [AdminController::class, 'storeOwner'])->name('admin.owners.store');
});
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/shops', [OwnerController::class, 'index'])->name('owner.shops.index');
    Route::get('/shops/create', [OwnerController::class, 'create'])->name('shops.create');
    Route::post('/shops', [OwnerController::class, 'store'])->name('shops.store');
    Route::get('/shops/reservations', [OwnerController::class, 'reservations'])->name('shops.reservations');
    Route::get('/owner/shops/{store}/edit', [OwnerController::class, 'edit'])->name('owner.shops.edit');
    Route::put('/owner/shops/{store}', [OwnerController::class, 'update'])->name('owner.shops.update');
    Route::get('/owner/send-mail', [MailController::class, 'showSendMailForm'])->name('owner.sendMailForm');
    Route::post('/owner/send-mail', [MailController::class, 'sendMail'])->name('owner.sendMail');
});


