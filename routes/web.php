<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('signin');
})->name('signin');

Route::redirect('/signin', '/');

Route::get('/dashboard', function(){
    return view('dashboard');
});
