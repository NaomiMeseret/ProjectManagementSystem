<?php

use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProjectController;
use App\Http\Controllers\Web\TaskController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/create', [ProjectController::class, 'create'])
        ->middleware('role:manager')
        ->name('projects.create');
    Route::post('projects', [ProjectController::class, 'store'])
        ->middleware('role:manager')
        ->name('projects.store');
    Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])
        ->middleware('role:admin,manager')
        ->name('projects.edit');
    Route::put('projects/{project}', [ProjectController::class, 'update'])
        ->middleware('role:admin,manager')
        ->name('projects.update');
    Route::delete('projects/{project}', [ProjectController::class, 'destroy'])
        ->middleware('role:admin,manager')
        ->name('projects.destroy');

    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::patch('tasks/{task}/status', [TaskController::class, 'changeStatus'])
        ->middleware('role:developer')
        ->name('tasks.change-status');
    Route::post('tasks/{task}/comments', [CommentController::class, 'store'])->name('tasks.comments.store');
    Route::get('projects/{project}/tasks/create', [TaskController::class, 'create'])
        ->middleware('role:manager')
        ->name('projects.tasks.create');
    Route::post('projects/{project}/tasks', [TaskController::class, 'store'])
        ->middleware('role:manager')
        ->name('projects.tasks.store');
    Route::get('projects/{project}/tasks/{task}/edit', [TaskController::class, 'edit'])
        ->middleware('role:admin,manager')
        ->name('projects.tasks.edit');
    Route::put('projects/{project}/tasks/{task}', [TaskController::class, 'update'])
        ->middleware('role:admin,manager')
        ->name('projects.tasks.update');
    Route::delete('projects/{project}/tasks/{task}', [TaskController::class, 'destroy'])
        ->middleware('role:admin,manager')
        ->name('projects.tasks.destroy');
});

require __DIR__.'/settings.php';
