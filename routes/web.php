<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoalController;

// TOPページ
Route::get('/', function () {
    return view('top');
});

// 
Route::get('/mypage', [GoalController::class, 'GoalIndex'])->middleware(['auth', 'verified'])->name('mypage');
Route::get('/goal/{id}', [GoalController::class, 'GoalShow'])->middleware(['auth', 'verified'])->name('show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
