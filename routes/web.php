<?php

use App\Http\Controllers\MFAController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SmartcardController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [VisitorController::class, 'visitorLog'])->name('home');
    Route::get('/about', fn() => view('about'))->name('about');
    Route::get('/contact', fn() => view('contact'))->name('contact');
    // Visitor Management Routes
    Route::get('/visitors/{id}/edit', [VisitorController::class, 'edit'])->name('visitors.edit');
    Route::delete('/visitors/{id}', [VisitorController::class, 'destroy'])->name('visitors.destroy');
    Route::put('/visitors/{id}', [VisitorController::class, 'update'])->name('visitors.update');
    // Visitor routes
    Route::get('/visitor-log', [VisitorController::class, 'visitorLog'])->name('visitor.log');
    Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index'); // Visitor log with search
    Route::post('/visitor/{id}/checkout', [VisitorController::class, 'checkout'])->name('visitor.checkout');
    Route::get('/visitors/{id}', [VisitorController::class, 'show'])->name('visitors.details');
    // Avoid duplicate route names
    Route::get('/home', [VisitorController::class, 'visitorLog'])->name('visitor.log.home');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Card reader routes
Route::get('/card-reader', [SmartcardController::class, 'show'])->name('card.reader');
Route::post('/read-card', [SmartcardController::class, 'readCard'])->name('card.read');







Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->get('/test-admin', function () {
    return 'Middleware works!';
});





// User Management Routes
route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/users', [AdminController::class, 'showUsersPage'])->name('users.manage');
    Route::delete('/user/{id}', [AdminController::class, 'deleteUser'])->name('delete.user');
    Route::get('/user/{id}/edit', [AdminController::class, 'editUser'])->name('edit.user');
    Route::post('/register-user', [AdminController::class, 'registerUser'])->name('register.user');
    Route::put('/user/{id}', [AdminController::class, 'updateUser'])->name('update.user');
    //export
    Route::get('/visitors/report/pdf', [VisitorController::class, 'exportPDF'])->name('visitors.report.pdf');
    Route::get('/visitors/report/excel', [VisitorController::class, 'exportExcel'])->name('visitors.report.excel');
});

//Route::get('/users', [AdminController::class, 'showUsersPage'])->name('users.manage');
//Route::delete('/user/{id}', [AdminController::class, 'deleteUser'])->name('delete.user');
//Route::get('/user/{id}/edit', [AdminController::class, 'editUser'])->name('edit.user');
//Route::post('/register-user', [AdminController::class, 'registerUser'])->name('register.user');
//Route::put('/user/{id}', [AdminController::class, 'updateUser'])->name('update.user');



Route::get('/admin/logs', function () {
    $logs = \App\Models\ActivityLog::with('user')->latest()->paginate(50);
    return view('admin.logs', compact('logs'));
})->middleware('auth', 'isAdmin');

Route::middleware('auth')->group(function () {
    Route::get('/mfa-prompt', [MFAController::class, 'showPrompt'])->name('mfa.prompt');
    Route::post('/mfa-verify', [MFAController::class, 'verifyOTP'])->name('mfa.verify');
});


Route::middleware(['auth', 'mfa'])->group(function () {
    Route::get('/home', function () {
        return view('home'); // Replace 'home' with the appropriate view name
    })->name('home');
});







