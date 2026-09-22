<?php

namespace Tests\Feature;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProyectoTest extends TestCase
{
    use RefreshDatabase;

    // ──────────────────────────────────────
    // Public access (guests)
    // ──────────────────────────────────────

    public function test_guests_can_view_project_listing(): void
    {
        $user = User::factory()->create();
        Proyecto::factory()->count(3)->for($user)->create();

        $response = $this->get(route('proyectos.index'));

        $response->assertOk();
        $response->assertViewHas('proyectos');
    }

    public function test_guests_can_view_a_single_project(): void
    {
        $proyecto = Proyecto::factory()->create();

        $response = $this->get(route('proyectos.show', $proyecto));

        $response->assertOk();
        $response->assertSee($proyecto->titulo);
    }

    public function test_guests_cannot_access_create_form(): void
    {
        $response = $this->get(route('proyectos.create'));

        $response->assertRedirect(route('login'));
    }

    // ──────────────────────────────────────
    // Authenticated users
    // ──────────────────────────────────────

    public function test_authenticated_user_can_create_a_project(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('proyectos.store'), [
            'titulo'  => 'Mi nuevo proyecto',
            'stack'   => 'Laravel, Vue.js',
            'estado'  => 'En progreso',
            'resumen' => 'Descripción del proyecto de prueba.',
        ]);

        $response->assertRedirect(route('proyectos.index'));
        $this->assertDatabaseHas('proyectos', [
            'titulo'  => 'Mi nuevo proyecto',
            'user_id' => $user->id,
        ]);
    }

    public function test_validation_rejects_empty_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('proyectos.store'), []);

        $response->assertInvalid(['titulo', 'stack', 'estado', 'resumen']);
    }

    public function test_owner_can_update_their_project(): void
    {
        $user = User::factory()->create();
        $proyecto = Proyecto::factory()->for($user)->create();

        $response = $this->actingAs($user)->put(route('proyectos.update', $proyecto), [
            'titulo'  => 'Título actualizado',
            'stack'   => $proyecto->stack,
            'estado'  => $proyecto->estado,
            'resumen' => $proyecto->resumen,
        ]);

        $response->assertRedirect(route('proyectos.show', $proyecto));
        $this->assertDatabaseHas('proyectos', ['titulo' => 'Título actualizado']);
    }

    public function test_owner_can_delete_their_project(): void
    {
        $user = User::factory()->create();
        $proyecto = Proyecto::factory()->for($user)->create();

        $response = $this->actingAs($user)->delete(route('proyectos.destroy', $proyecto));

        $response->assertRedirect(route('proyectos.index'));
        $this->assertDatabaseMissing('proyectos', ['id' => $proyecto->id]);
    }

    // ──────────────────────────────────────
    // Authorization (Policy)
    // ──────────────────────────────────────

    public function test_user_cannot_update_another_users_project(): void
    {
        $owner = User::factory()->create();
        $stranger = User::factory()->create();
        $proyecto = Proyecto::factory()->for($owner)->create();

        $response = $this->actingAs($stranger)->put(route('proyectos.update', $proyecto), [
            'titulo'  => 'Hackeado',
            'stack'   => $proyecto->stack,
            'estado'  => $proyecto->estado,
            'resumen' => $proyecto->resumen,
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('proyectos', ['titulo' => 'Hackeado']);
    }

    public function test_user_cannot_delete_another_users_project(): void
    {
        $owner = User::factory()->create();
        $stranger = User::factory()->create();
        $proyecto = Proyecto::factory()->for($owner)->create();

        $response = $this->actingAs($stranger)->delete(route('proyectos.destroy', $proyecto));

        $response->assertForbidden();
        $this->assertDatabaseHas('proyectos', ['id' => $proyecto->id]);
    }

    // ──────────────────────────────────────
    // Search & Filters
    // ──────────────────────────────────────

    public function test_projects_can_be_filtered_by_estado(): void
    {
        $user = User::factory()->create();
        Proyecto::factory()->for($user)->completado()->create(['titulo' => 'Hecho']);
        Proyecto::factory()->for($user)->enProgreso()->create(['titulo' => 'WIP']);

        $response = $this->get(route('proyectos.index', ['estado' => 'Completado']));

        $response->assertOk();
        $response->assertSee('Hecho');
        $response->assertDontSee('WIP');
    }

    public function test_projects_can_be_searched_by_titulo(): void
    {
        $user = User::factory()->create();
        Proyecto::factory()->for($user)->create(['titulo' => 'Laravel API']);
        Proyecto::factory()->for($user)->create(['titulo' => 'React App']);

        $response = $this->get(route('proyectos.index', ['buscar' => 'Laravel']));

        $response->assertOk();
        $response->assertSee('Laravel API');
        $response->assertDontSee('React App');
    }
}
