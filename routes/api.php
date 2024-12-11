<?php
// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmartcardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CheckinController;

Route::post('save-checkin', [CheckinController::class, 'save']);

Route::post('save-checkout', [CheckoutController::class, 'save'])->name('checkout.save');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::get('/checkout/{id}', [CheckoutController::class, 'show'])->name('checkout.show');

//Route::post('/smartcard/read-card', [SmartcardController::class, 'readCard']);
//Route::post('/smartcard/checkin', [SmartcardController::class, 'checkIn'])->name('smartcard.checkin');
//Route::post('/smartcard/checkout', [SmartcardController::class, 'checkOut'])->name('smartcard.checkout');
