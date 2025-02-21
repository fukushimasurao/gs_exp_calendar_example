<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

route::get('/hello-html', function () {
    return '<h1>HELLO WORLD</h1>';
});

Route::get('/hello', [HelloController::class, 'hello']);
Route::get('/good-bye', [GoodByeController::class, 'goodBye']);

// ⭐️追加！
Route::get('/members', [MemberController::class, 'index']);

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/create', [ProductController::class, 'create']); // フォーム表示
Route::post('/products', [ProductController::class, 'store']); // データ登録

require __DIR__.'/auth.php';


