<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['titulo', 'stack', 'estado', 'resumen'])]
class Proyecto extends Model
{
    use HasFactory;
    // ──────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────

    /**
     * The user who owns this project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The tags associated with this project.
     */
    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(Etiqueta::class);
    }

    // ──────────────────────────────────────
    // Query Scopes
    // ──────────────────────────────────────

    /**
     * Filter projects by estado.
     */
    public function scopeEstado(Builder $query, string $estado): Builder
    {
        return $query->where('estado', $estado);
    }

    /**
     * Search projects by titulo or resumen.
     */
    public function scopeBuscar(Builder $query, ?string $termino): Builder
    {
        if (! $termino) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($termino) {
            $q->where('titulo', 'like', "%{$termino}%")
              ->orWhere('resumen', 'like', "%{$termino}%")
              ->orWhere('stack', 'like', "%{$termino}%");
        });
    }

    /**
     * Filter projects by etiqueta.
     */
    public function scopeConEtiqueta(Builder $query, string $slug): Builder
    {
        return $query->whereHas('etiquetas', fn (Builder $q) => $q->where('slug', $slug));
    }
}