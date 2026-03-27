<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::get('/projects', [ProjectController::class, 'index'])->name('api.projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])
        ->middleware('role:manager')
        ->name('api.projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('api.projects.show');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])
        ->middleware('role:admin,manager')
        ->name('api.projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])
        ->middleware('role:admin,manager')
        ->name('api.projects.destroy');

    Route::get('/tasks', [TaskController::class, 'index'])->name('api.tasks.index');
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])
        ->middleware('role:manager')
        ->name('api.tasks.store');
    Route::put('/projects/{project}/tasks/{task}', [TaskController::class, 'update'])
        ->middleware('role:admin,manager')
        ->name('api.tasks.update');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'changeStatus'])
        ->middleware('role:developer')
        ->name('api.tasks.change-status');
    Route::delete('/projects/{project}/tasks/{task}', [TaskController::class, 'destroy'])
        ->middleware('role:admin,manager')
        ->name('api.tasks.destroy');

    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('api.comments.store');
});
