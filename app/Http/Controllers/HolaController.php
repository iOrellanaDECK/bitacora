<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\View\View;

class HolaController extends Controller
{
    public function index(): View
    {
        return view('hola', [
            'titulo' => 'Bitácora',
            'proyectos' => Proyecto::all(),
        ]);
    }
}
