<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyectoController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('proyectos.index'));

Route::get('/dashboard', fn () => redirect()->route('proyectos.index'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated routes (defined before public show route so /proyectos/create is matched before /proyectos/{proyecto})
Route::middleware('auth')->group(function () {
    Route::resource('proyectos', ProyectoController::class)
        ->except(['index', 'show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public routes
Route::resource('proyectos', ProyectoController::class)
    ->only(['index', 'show']);

require __DIR__.'/auth.php';
