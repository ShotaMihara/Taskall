<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\GeminiController;

// TOPページ
Route::get('/', function () {
    return view('top');
});

// 
Route::get('/mypage', [GoalController::class, 'GoalIndex'])->middleware(['auth', 'verified'])->name('mypage');
Route::get('/goal/{id}', [GoalController::class, 'GoalShow'])->middleware(['auth', 'verified'])->name('show');
Route::get('/ask', [GeminiController::class, 'askQuestion'])->middleware(['auth', 'verified'])->name('ask');
Route::view('/setting', 'setting')->middleware(['auth', 'verified'])->name('setting');
// Route::get('/list-models', [GeminiController::class, 'listModels'])->middleware(['auth', 'verified'])->name('listModels');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
