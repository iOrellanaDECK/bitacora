<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProyectoRequest;
use App\Http\Requests\UpdateProyectoRequest;
use App\Models\Etiqueta;
use App\Models\Proyecto;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProyectoController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of all projects.
     * Public: guests and authenticated users can view.
     */
    public function index(Request $request): View
    {
        $proyectos = Proyecto::query()
            ->with(['user', 'etiquetas'])
            ->buscar($request->query('buscar'))
            ->when($request->query('estado'), fn ($q, $estado) => $q->estado($estado))
            ->when($request->query('etiqueta'), fn ($q, $slug) => $q->conEtiqueta($slug))
            ->latest()
            ->get();

        $etiquetas = Etiqueta::orderBy('nombre')->get();

        return view('proyectos.index', compact('proyectos', 'etiquetas'));
    }

    /**
     * Show the form for creating a new project.
     * Requires authentication.
     */
    public function create(): View
    {
        $this->authorize('create', Proyecto::class);

        return view('proyectos.create');
    }

    /**
     * Store a newly created project in the database.
     * Requires authentication.
     */
    public function store(StoreProyectoRequest $request): RedirectResponse
    {
        $this->authorize('create', Proyecto::class);

        $proyecto = $request->user()->proyectos()->create(
            $request->safe()->except('etiquetas')
        );

        $this->syncEtiquetas($proyecto, $request->validated('etiquetas'));

        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto creado exitosamente.');
    }

    /**
     * Display the specified project.
     * Public: guests and authenticated users can view.
     */
    public function show(Proyecto $proyecto): View
    {
        $proyecto->load(['user', 'etiquetas']);

        return view('proyectos.show', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified project.
     * Only the owner can edit.
     */
    public function edit(Proyecto $proyecto): View
    {
        $this->authorize('update', $proyecto);

        $proyecto->load('etiquetas');

        return view('proyectos.edit', compact('proyecto'));
    }

    /**
     * Update the specified project in the database.
     * Only the owner can update.
     */
    public function update(UpdateProyectoRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $this->authorize('update', $proyecto);

        $proyecto->update($request->safe()->except('etiquetas'));

        $this->syncEtiquetas($proyecto, $request->validated('etiquetas'));

        return redirect()->route('proyectos.show', $proyecto)
            ->with('success', 'Proyecto actualizado exitosamente.');
    }

    /**
     * Remove the specified project from the database.
     * Only the owner can delete.
     */
    public function destroy(Proyecto $proyecto): RedirectResponse
    {
        $this->authorize('delete', $proyecto);

        $proyecto->delete();

        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto eliminado exitosamente.');
    }

    /**
     * Sync etiquetas from a comma-separated string.
     */
    private function syncEtiquetas(Proyecto $proyecto, ?string $etiquetasInput): void
    {
        if (! $etiquetasInput) {
            $proyecto->etiquetas()->detach();
            return;
        }

        $ids = collect(explode(',', $etiquetasInput))
            ->map(fn ($name) => trim($name))
            ->filter()
            ->map(fn ($name) => Etiqueta::findOrCreateByName($name)->id);

        $proyecto->etiquetas()->sync($ids);
    }
}
