<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Proyecto
 */
class ProyectoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'titulo'     => $this->titulo,
            'stack'      => $this->stack,
            'estado'     => $this->estado,
            'resumen'    => $this->resumen,
            'etiquetas'  => $this->whenLoaded('etiquetas', fn () =>
                $this->etiquetas->pluck('nombre')
            ),
            'autor'      => $this->whenLoaded('user', fn () => [
                'id'     => $this->user->id,
                'nombre' => $this->user->name,
            ]),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
