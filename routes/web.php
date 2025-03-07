<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\GeminiController;

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

    //  スケジュール削除
    Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

    //  追加スケジュール修正画面
    Route::get('/schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');

    // スケジュール修正処理
    Route::patch('/schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');

    // ⭐️ 生成AI利用画面追加
    Route::get('/ai-consult', [GeminiController::class, 'showConsultPage'])->name('ai-consult');

    // ⭐️ postリクエストを受け取るルートを追加
    Route::post('/gemini-response', [GeminiController::class, 'generateResponse'])->name('gemini.response');
});

require __DIR__.'/auth.php';
