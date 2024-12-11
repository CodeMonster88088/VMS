<?php

use App\Http\Controllers\VisitorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SmartcardController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [VisitorController::class, 'visitorLog'])->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/contact', fn() => view('contact'))->name('contact');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Card reader routes
Route::get('/card-reader', [SmartcardController::class, 'show'])->name('card.reader');
Route::post('/read-card', [SmartcardController::class, 'readCard'])->name('card.read');

// Visitor routes
Route::get('/visitor-log', [VisitorController::class, 'visitorLog'])->name('visitor.log');
Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index'); // Visitor log with search
Route::get('/visitors/{id}', [VisitorController::class, 'show'])->name('visitors.details');
Route::post('/visitor/{id}/checkout', [VisitorController::class, 'checkout'])->name('visitor.checkout');


// Admin-only routes
//Route::middleware(['auth', 'admin'])->group(function () {
//    Route::get('/users', [AdminController::class, 'showUsersPage'])->name('users.manage');
//    Route::get('/admin-dashboard', [AdminController::class, 'showHomePage'])->name('admin.dashboard');
//    Route::delete('/user/{id}', [AdminController::class, 'deleteUser'])->name('delete.user');
//    Route::get('/user/{id}/edit', [AdminController::class, 'editUser'])->name('edit.user');
//    Route::post('/register-user', [AdminController::class, 'registerUser'])->name('register.user');
//    Route::put('/user/{id}', [AdminController::class, 'updateUser'])->name('update.user');
//});

Route::get('/users', [AdminController::class, 'showUsersPage'])->name('users.manage');
Route::get('/admin-dashboard', [AdminController::class, 'showHomePage'])->name('admin.dashboard');
Route::delete('/user/{id}', [AdminController::class, 'deleteUser'])->name('delete.user');
Route::get('/user/{id}/edit', [AdminController::class, 'editUser'])->name('edit.user');
Route::post('/register-user', [AdminController::class, 'registerUser'])->name('register.user');
Route::put('/user/{id}', [AdminController::class, 'updateUser'])->name('update.user');
Route::get('/admin-dashboard', [AdminController::class, 'showHomePage'])->name('admin.dashboard');


// Avoid duplicate route names
Route::get('/home', [VisitorController::class, 'visitorLog'])->name('visitor.log.home');
