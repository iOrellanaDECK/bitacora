<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

#[Fillable(['nombre', 'slug'])]
class Etiqueta extends Model
{
    // ──────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────

    /**
     * The projects that have this tag.
     */
    public function proyectos(): BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class);
    }

    // ──────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────

    /**
     * Find or create an etiqueta by name.
     */
    public static function findOrCreateByName(string $nombre): self
    {
        return static::firstOrCreate(
            ['slug' => Str::slug($nombre)],
            ['nombre' => trim($nombre)],
        );
    }
}
