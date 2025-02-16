<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'HELLO WORLD';
});

Route::get('/hello-html', function () {
    return '<h1>HELLO WORLD</h1>';
});
