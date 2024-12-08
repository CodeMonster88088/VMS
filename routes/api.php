<?php
// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmartcardController;
use App\Http\Controllers\CheckinController;

Route::post('save-checkin', [CheckinController::class, 'save']);

Route::post('/save-checkout', [SmartcardController::class, 'saveCheckout']);

Route::post('/smartcard/read-card', [SmartcardController::class, 'readCard']);
Route::post('/smartcard/checkin', [SmartcardController::class, 'checkIn'])->name('smartcard.checkin');
Route::post('/smartcard/checkout', [SmartcardController::class, 'checkOut'])->name('smartcard.checkout');
