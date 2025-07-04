<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;



Route::get('/', function () {
    return view('cart');
})->name('home');

Route::post('/orders/create', [OrderController::class, 'store'])->name('order.create');


Route::get('/checkout/{orderId}', [CheckoutController::class, 'showDetailsForm'])->name('show.details.form')->middleware('ensureOrderNotPaid');
Route::post('/checkout/{order}', [CheckoutController::class, 'checkout'])->name('checkout');

Route::post('/payment/return', [CheckoutController::class, 'handleReturnUrl'])->name('payment.return');
Route::match(['get', 'post'], '/payment/success/{id?}', [CheckoutController::class, 'paymentSuccess'])->name('payment.success');
Route::match(['get', 'post'], '/payment/failure', [CheckoutController::class, 'paymentFailure'])->name('payment.failure');
Route::post('/payment/callback', [CheckoutController::class, 'paymentCallback'])->name('payment.callback');

Route::get('payment/refund/{order}', [CheckoutController::class, 'fullRefund'])->name('payment.refund');

// Simple error page route
Route::get('/error', function () {
    return view('error');
})->name('error');


