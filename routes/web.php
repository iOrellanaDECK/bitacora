<?php

use App\Http\Controllers\ProyectoController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('proyectos.index'));

Route::resource('proyectos', ProyectoController::class);