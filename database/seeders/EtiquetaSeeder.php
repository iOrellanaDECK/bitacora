<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EtiquetaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed common technology tags.
     */
    public function run(): void
    {
        $etiquetas = [
            'Backend', 'Frontend', 'Full Stack', 'API',
            'Base de Datos', 'DevOps', 'Testing', 'UI/UX',
            'Autenticación', 'WebSockets', 'E-commerce', 'CLI',
        ];

        foreach ($etiquetas as $nombre) {
            Etiqueta::create([
                'nombre' => $nombre,
                'slug'   => Str::slug($nombre),
            ]);
        }
    }
}
