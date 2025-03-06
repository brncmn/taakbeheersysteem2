<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Tasks
Route::put('/tasks/{id}', [TasksController::class, 'update'])->name('tasks.update');
Route::delete('tasks/{tasks}', [TasksController::class, 'destroy'])->name('tasks.destroy');
Route::put('/tasks/{tasks}/status', [TasksController::class, 'updateStatus'])->name('tasks.updateStatus');
Route::get('/alltasks', [TasksController::class, 'allTasks'])->name('alltasks');


Route::middleware('admin')->group(function(){
    Route::get('/beheertaken', [TasksController::class, 'index'])->name('admin.managetasks');
    Route::post('/taakaanmaken', [TasksController::class, 'store'])->name('tasks.store');
});

require __DIR__.'/auth.php';
