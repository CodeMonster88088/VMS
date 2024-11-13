<?php

use Illuminate\Support\Facades\Route;

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
