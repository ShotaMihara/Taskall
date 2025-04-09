<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\TaskController;

// TOPページ（認証不要）
Route::get('/', function () {
    return view('top');
});

// 認証が必要なルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [GoalController::class, 'GoalIndex'])->name('mypage');
    Route::get('/goal/{id}', [GoalController::class, 'GoalShow'])->name('show');
    Route::get('/ask', [GeminiController::class, 'askQuestion'])->name('ask');
    Route::view('/setting', 'setting')->name('setting');

    Route::post('/save-to-database', [GeminiController::class, 'saveToDatabase'])->name('save.to.database');

    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::patch('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::delete('/goals/{goal}', [GoalController::class, 'goalDestroy'])->name('goals.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
