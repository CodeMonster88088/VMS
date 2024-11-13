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
Route::get('/login', function () {
    return view('login');
});
