@php
    $estados = \App\Http\Requests\StoreProyectoRequest::estadosPermitidos();
@endphp

<div class="space-y-6">
    {{-- Título --}}
    <div>
        <x-input-label for="titulo" value="Título del proyecto" />
        <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full"
                      :value="old('titulo', $proyecto->titulo ?? '')"
                      placeholder="Ej: API de gestión de tareas" required />
        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
    </div>

    {{-- Stack --}}
    <div>
        <x-input-label for="stack" value="Stack / Tecnologías" />
        <x-text-input id="stack" name="stack" type="text" class="mt-1 block w-full"
                      :value="old('stack', $proyecto->stack ?? '')"
                      placeholder="Ej: Laravel, Vue.js, MySQL" required />
        <p class="mt-1 text-xs text-gray-500">Separa las tecnologías con comas.</p>
        <x-input-error :messages="$errors->get('stack')" class="mt-2" />
    </div>

    {{-- Estado --}}
    <div>
        <x-input-label for="estado" value="Estado" />
        <select name="estado" id="estado"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                required>
            <option value="">Selecciona un estado</option>
            @foreach ($estados as $estado)
                <option value="{{ $estado }}"
                    {{ old('estado', $proyecto->estado ?? '') === $estado ? 'selected' : '' }}>
                    {{ $estado }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('estado')" class="mt-2" />
    </div>

    {{-- Etiquetas --}}
    <div>
        <x-input-label for="etiquetas" value="Etiquetas" />
        <x-text-input id="etiquetas" name="etiquetas" type="text" class="mt-1 block w-full"
                      :value="old('etiquetas', isset($proyecto) && $proyecto->exists ? $proyecto->etiquetas->pluck('nombre')->implode(', ') : '')"
                      placeholder="Ej: Backend, API, Testing" />
        <p class="mt-1 text-xs text-gray-500">Separa las etiquetas con comas. Se crearán automáticamente si no existen.</p>
        <x-input-error :messages="$errors->get('etiquetas')" class="mt-2" />
    </div>

    {{-- Resumen --}}
    <div>
        <x-input-label for="resumen" value="Resumen" />
        <textarea name="resumen" id="resumen" rows="5"
                  placeholder="Describe de qué trata el proyecto, qué aprendiste, qué problemas resolviste..."
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm resize-y"
                  required>{{ old('resumen', $proyecto->resumen ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('resumen')" class="mt-2" />
    </div>

    {{-- Botones --}}
    <div class="flex items-center gap-3 pt-2">
        <x-primary-button>
            {{ isset($proyecto) && $proyecto->exists ? 'Guardar cambios' : 'Crear proyecto' }}
        </x-primary-button>
        <a href="{{ isset($proyecto) && $proyecto->exists ? route('proyectos.show', $proyecto) : route('proyectos.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
            Cancelar
        </a>
    </div>
</div>
