<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proyecto>
 */
class ProyectoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stacks = [
            'Laravel, Vue.js, MySQL',
            'React, Node.js, MongoDB',
            'Django, PostgreSQL, Redis',
            'Spring Boot, Angular, Oracle',
            'Laravel, Livewire, SQLite',
            'Next.js, Prisma, PostgreSQL',
            'PHP, jQuery, MariaDB',
            'Python, FastAPI, Docker',
        ];

        return [
            'user_id' => User::factory(),
            'titulo'  => fake()->sentence(3),
            'stack'   => fake()->randomElement($stacks),
            'estado'  => fake()->randomElement(['En progreso', 'Completado', 'Pausado', 'Planeado']),
            'resumen' => fake()->paragraphs(2, true),
        ];
    }

    /**
     * Set the project state to completed.
     */
    public function completado(): static
    {
        return $this->state(['estado' => 'Completado']);
    }

    /**
     * Set the project state to in progress.
     */
    public function enProgreso(): static
    {
        return $this->state(['estado' => 'En progreso']);
    }
}
