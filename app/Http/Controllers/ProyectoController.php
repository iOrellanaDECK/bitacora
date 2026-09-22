<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProyectoController extends Controller
{
    /**
     * Display a listing of all projects.
     */
    public function index(): View
    {
        $proyectos = Proyecto::latest()->get();

        return view('proyectos.index', compact('proyectos'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        return view('proyectos.create');
    }

    /**
     * Store a newly created project in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo'  => 'required|string|max:255',
            'stack'   => 'required|string|max:255',
            'estado'  => 'required|string|in:En progreso,Completado,Pausado,Planeado',
            'resumen' => 'required|string',
        ]);

        Proyecto::create($validated);

        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto creado exitosamente.');
    }

    /**
     * Display the specified project.
     */
    public function show(Proyecto $proyecto): View
    {
        return view('proyectos.show', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Proyecto $proyecto): View
    {
        return view('proyectos.edit', compact('proyecto'));
    }

    /**
     * Update the specified project in the database.
     */
    public function update(Request $request, Proyecto $proyecto): RedirectResponse
    {
        $validated = $request->validate([
            'titulo'  => 'required|string|max:255',
            'stack'   => 'required|string|max:255',
            'estado'  => 'required|string|in:En progreso,Completado,Pausado,Planeado',
            'resumen' => 'required|string',
        ]);

        $proyecto->update($validated);

        return redirect()->route('proyectos.show', $proyecto)
            ->with('success', 'Proyecto actualizado exitosamente.');
    }

    /**
     * Remove the specified project from the database.
     */
    public function destroy(Proyecto $proyecto): RedirectResponse
    {
        $proyecto->delete();

        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto eliminado exitosamente.');
    }
}
