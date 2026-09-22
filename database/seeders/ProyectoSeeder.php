<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProyectoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with sample projects.
     */
    public function run(): void
    {
        $user = User::first();

        $etiquetas = Etiqueta::all()->keyBy('slug');

        $proyectos = [
            [
                'titulo'     => 'Bitácora — Portafolio Laravel',
                'stack'      => 'Laravel 13, PHP 8.5, SQLite, Tailwind CSS, Blade',
                'estado'     => 'En progreso',
                'resumen'    => 'Catálogo público de proyectos personales construido con Laravel 13. Incluye CRUD completo con autenticación, autorización por policies, API REST, relaciones many-to-many, y tests automatizados. Diseño responsive con Tailwind CSS.',
                'etiquetas'  => ['backend', 'full-stack', 'base-de-datos'],
            ],
            [
                'titulo'     => 'API REST de Tareas',
                'stack'      => 'Laravel, MySQL, Sanctum, Postman',
                'estado'     => 'Completado',
                'resumen'    => 'API RESTful para gestión de tareas con autenticación via Laravel Sanctum. Endpoints para CRUD de tareas, asignación de usuarios y filtros por estado. Documentada con colección Postman.',
                'etiquetas'  => ['backend', 'api', 'autenticacion'],
            ],
            [
                'titulo'     => 'Chat en Tiempo Real',
                'stack'      => 'Node.js, Socket.io, Express, MongoDB',
                'estado'     => 'Completado',
                'resumen'    => 'Aplicación de chat con salas múltiples usando WebSockets. Los usuarios pueden crear salas, enviar mensajes en tiempo real y ver quién está conectado. Historial de mensajes persistido en MongoDB.',
                'etiquetas'  => ['full-stack', 'websockets', 'base-de-datos'],
            ],
            [
                'titulo'     => 'Dashboard de Métricas',
                'stack'      => 'Vue.js, Chart.js, Laravel API, PostgreSQL',
                'estado'     => 'En progreso',
                'resumen'    => 'Panel de visualización de datos con gráficas interactivas. Consume una API Laravel para obtener métricas de ventas, usuarios activos y rendimiento. Incluye filtros por rango de fechas y exportación a CSV.',
                'etiquetas'  => ['frontend', 'api', 'ui-ux'],
            ],
            [
                'titulo'     => 'CLI de Automatización DevOps',
                'stack'      => 'Python, Click, Docker, AWS CLI',
                'estado'     => 'Pausado',
                'resumen'    => 'Herramienta de línea de comandos para automatizar despliegues. Gestiona contenedores Docker, sincroniza archivos con S3 y ejecuta scripts de migración. En pausa mientras aprendo más sobre CI/CD.',
                'etiquetas'  => ['devops', 'cli'],
            ],
            [
                'titulo'     => 'E-commerce con Pasarela de Pago',
                'stack'      => 'Laravel, Livewire, Stripe, Tailwind CSS',
                'estado'     => 'Planeado',
                'resumen'    => 'Tienda online con carrito de compras, pasarela de pago Stripe y panel de administración. Planeado como proyecto para practicar Livewire y la integración con servicios de pago externos.',
                'etiquetas'  => ['full-stack', 'e-commerce', 'autenticacion'],
            ],
        ];

        foreach ($proyectos as $data) {
            $tags = $data['etiquetas'];
            unset($data['etiquetas']);

            $proyecto = $user->proyectos()->create($data);

            $tagIds = $etiquetas->only($tags)->pluck('id');
            $proyecto->etiquetas()->attach($tagIds);
        }
    }
}
