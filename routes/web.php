<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;

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

    Route::post('/schedule-add', [ScheduleController::class, 'scheduleAdd'])->name('schedule-add');
    Route::post('/schedule-get', [ScheduleController::class, 'scheduleGet'])->name('schedule-get');
    
    // スケジュール一覧画面
    Route::get('/schedule-list', [ScheduleController::class, 'scheduleList'])->name('schedule-list');

    // スケジュール詳細画面
    Route::get('/schedules/{id}', [ScheduleController::class, 'show'])->name('schedules.show');
});

require __DIR__.'/auth.php';
