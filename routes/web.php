<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});
Route::get('/login', function () {
    return view('login');
});
