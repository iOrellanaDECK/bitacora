<?php

namespace Tests\Feature\Api;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProyectoTest extends TestCase
{
    use RefreshDatabase;

    // ──────────────────────────────────────
    // Public API endpoints
    // ──────────────────────────────────────

    public function test_api_lists_projects_with_pagination(): void
    {
        $user = User::factory()->create();
        Proyecto::factory()->count(3)->for($user)->create();

        $response = $this->getJson('/api/proyectos');

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'titulo', 'stack', 'estado', 'resumen', 'autor', 'created_at'],
            ],
            'links',
            'meta',
        ]);
    }

    public function test_api_shows_single_project(): void
    {
        $proyecto = Proyecto::factory()->create();

        $response = $this->getJson("/api/proyectos/{$proyecto->id}");

        $response->assertOk();
        $response->assertJsonPath('data.titulo', $proyecto->titulo);
    }

    public function test_api_filters_by_estado(): void
    {
        $user = User::factory()->create();
        Proyecto::factory()->for($user)->completado()->create();
        Proyecto::factory()->for($user)->enProgreso()->create();

        $response = $this->getJson('/api/proyectos?estado=Completado');

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.estado', 'Completado');
    }

    public function test_api_searches_projects(): void
    {
        $user = User::factory()->create();
        Proyecto::factory()->for($user)->create(['titulo' => 'Laravel API']);
        Proyecto::factory()->for($user)->create(['titulo' => 'React App']);

        $response = $this->getJson('/api/proyectos?buscar=Laravel');

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
    }

    // ──────────────────────────────────────
    // Authenticated API endpoints
    // ──────────────────────────────────────

    public function test_api_authenticated_user_can_create_project(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/proyectos', [
            'titulo'  => 'Nuevo vía API',
            'stack'   => 'Laravel, Vue.js',
            'estado'  => 'En progreso',
            'resumen' => 'Creado desde la API.',
        ]);

        $response->assertCreated();
        $response->assertJsonPath('data.titulo', 'Nuevo vía API');
        $this->assertDatabaseHas('proyectos', ['titulo' => 'Nuevo vía API']);
    }

    public function test_api_unauthenticated_user_cannot_create_project(): void
    {
        $response = $this->postJson('/api/proyectos', [
            'titulo'  => 'Sin auth',
            'stack'   => 'Nada',
            'estado'  => 'Planeado',
            'resumen' => 'No debería funcionar.',
        ]);

        $response->assertUnauthorized();
    }

    public function test_api_owner_can_update_project(): void
    {
        $user = User::factory()->create();
        $proyecto = Proyecto::factory()->for($user)->create();

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/proyectos/{$proyecto->id}", [
                'titulo' => 'Actualizado vía API',
            ]);

        $response->assertOk();
        $this->assertDatabaseHas('proyectos', ['titulo' => 'Actualizado vía API']);
    }

    public function test_api_owner_can_delete_project(): void
    {
        $user = User::factory()->create();
        $proyecto = Proyecto::factory()->for($user)->create();

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/proyectos/{$proyecto->id}");

        $response->assertOk();
        $this->assertDatabaseMissing('proyectos', ['id' => $proyecto->id]);
    }

    public function test_api_stranger_cannot_update_project(): void
    {
        $owner = User::factory()->create();
        $stranger = User::factory()->create();
        $proyecto = Proyecto::factory()->for($owner)->create();

        $response = $this->actingAs($stranger, 'sanctum')
            ->putJson("/api/proyectos/{$proyecto->id}", [
                'titulo' => 'Hackeado',
            ]);

        $response->assertForbidden();
    }
}
