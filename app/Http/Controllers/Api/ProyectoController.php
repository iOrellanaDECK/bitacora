<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProyectoResource;
use App\Models\Proyecto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProyectoController extends Controller
{
    /**
     * GET /api/proyectos
     *
     * List projects with optional filters: ?buscar=, ?estado=, ?etiqueta=
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $proyectos = Proyecto::query()
            ->with(['user', 'etiquetas'])
            ->buscar($request->query('buscar'))
            ->when($request->query('estado'), fn ($q, $estado) => $q->estado($estado))
            ->when($request->query('etiqueta'), fn ($q, $slug) => $q->conEtiqueta($slug))
            ->latest()
            ->paginate(15);

        return ProyectoResource::collection($proyectos);
    }

    /**
     * GET /api/proyectos/{proyecto}
     *
     * Show a single project.
     */
    public function show(Proyecto $proyecto): ProyectoResource
    {
        $proyecto->load(['user', 'etiquetas']);

        return new ProyectoResource($proyecto);
    }

    /**
     * POST /api/proyectos (requires auth:sanctum)
     *
     * Create a new project for the authenticated user.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'titulo'  => ['required', 'string', 'max:255'],
            'stack'   => ['required', 'string', 'max:255'],
            'estado'  => ['required', 'string', 'in:En progreso,Completado,Pausado,Planeado'],
            'resumen' => ['required', 'string', 'max:2000'],
        ]);

        $proyecto = $request->user()->proyectos()->create($validated);
        $proyecto->load(['user', 'etiquetas']);

        return (new ProyectoResource($proyecto))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * PUT /api/proyectos/{proyecto} (requires auth:sanctum + ownership)
     *
     * Update a project.
     */
    public function update(Request $request, Proyecto $proyecto): ProyectoResource
    {
        $this->authorize('update', $proyecto);

        $validated = $request->validate([
            'titulo'  => ['sometimes', 'required', 'string', 'max:255'],
            'stack'   => ['sometimes', 'required', 'string', 'max:255'],
            'estado'  => ['sometimes', 'required', 'string', 'in:En progreso,Completado,Pausado,Planeado'],
            'resumen' => ['sometimes', 'required', 'string', 'max:2000'],
        ]);

        $proyecto->update($validated);
        $proyecto->load(['user', 'etiquetas']);

        return new ProyectoResource($proyecto);
    }

    /**
     * DELETE /api/proyectos/{proyecto} (requires auth:sanctum + ownership)
     *
     * Delete a project.
     */
    public function destroy(Proyecto $proyecto): JsonResponse
    {
        $this->authorize('delete', $proyecto);

        $proyecto->delete();

        return response()->json(['message' => 'Proyecto eliminado.'], 200);
    }
}
