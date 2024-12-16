<?php
// routes/api.php

use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmartcardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CheckinController;

Route::post('save-checkin', [VisitorController::class, 'checkIn'])->name('checkin.save');
Route::post('/validate-checkin', [VisitorController::class, 'validateCheckin']);
Route::post('save-checkout', [VisitorController::class, 'checkOut'])->name('checkout.save');


//Route::post('/smartcard/read-card', [SmartcardController::class, 'readCard']);
//Route::post('/smartcard/checkin', [SmartcardController::class, 'checkIn'])->name('smartcard.checkin');
//Route::post('/smartcard/checkout', [SmartcardController::class, 'checkOut'])->name('smartcard.checkout');
