<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HelloController;
use App\Http\Controllers\GoodByeController;


Route::get('/', function () {
    return view('welcome');
});

// ⭐️⭐️⭐️⭐️ ↓このrouteはコメントアウト or 消してください。
//Route::get('/hello', function () {
//    return 'HELLO WORLD';
//});

Route::get('/hello-html', function () {
    return '<h1>HELLO WORLD</h1>';
});

Route::get('/hello', [HelloController::class, 'hello']);
Route::get('/good-bye', [GoodByeController::class, 'goodBye']);
