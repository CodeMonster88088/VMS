<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SmartcardController;

Route::get('/', function () {
    return view('home' , ['greeting' => 'Hello' , 'name' => 'Ali']);
});

Route::get('/about', function () {
    return view('about');
    //about page
});

Route::get('/contact', function () {
    return view('contact');
});
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Add this route for displaying the home page with the form
Route::get('/', [AdminController::class, 'showHomePage'])->name('home');

// Add this route for handling the registration
Route::post('/register-user', [AdminController::class, 'registerUser'])->name('register.user');

Route::get('/', [AdminController::class, 'showHomePage'])->name('home');
Route::delete('/user/{id}', [AdminController::class, 'deleteUser'])->name('delete.user');
Route::get('/user/{id}/edit', [AdminController::class, 'editUser'])->name('edit.user');

Route::put('/user/{id}', [AdminController::class, 'updateUser'])->name('update.user');
//card reader route
Route::get('/card-reader', [SmartcardController::class, 'show'])->name('card.reader');
Route::post('/read-card', [SmartcardController::class, 'readCard'])->name('card.read');
//Route::post('/card-reader/checkin', [SmartcardController::class, 'checkin'])->name('card.checkin');
//Route::post('/card-reader/checkout', [SmartcardController::class, 'checkout'])->name('card.checkout');





