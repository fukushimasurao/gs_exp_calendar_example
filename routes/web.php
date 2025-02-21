<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HelloController;
use App\Http\Controllers\GoodByeController;

// ⭐️追加！
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello-html', function () {
    return '<h1>HELLO WORLD</h1>';
});

Route::get('/hello', [HelloController::class, 'hello']);
Route::get('/good-bye', [GoodByeController::class, 'goodBye']);

// ⭐️追加！
Route::get('/members', [MemberController::class, 'index']);

Route::get('/products', [ProductController::class, 'index']);
