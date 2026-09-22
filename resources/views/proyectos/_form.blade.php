@php
    $estados = ['En progreso', 'Completado', 'Pausado', 'Planeado'];
@endphp

<div class="space-y-6">
    {{-- Título --}}
    <div>
        <label for="titulo" class="block text-sm font-medium text-slate-700 mb-1">Título del proyecto</label>
        <input type="text" name="titulo" id="titulo"
               value="{{ old('titulo', $proyecto->titulo ?? '') }}"
               placeholder="Ej: API de gestión de tareas"
               class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition-colors
                      @error('titulo') border-red-400 @enderror">
        @error('titulo')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Stack --}}
    <div>
        <label for="stack" class="block text-sm font-medium text-slate-700 mb-1">Stack / Tecnologías</label>
        <input type="text" name="stack" id="stack"
               value="{{ old('stack', $proyecto->stack ?? '') }}"
               placeholder="Ej: Laravel, Vue.js, MySQL"
               class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition-colors
                      @error('stack') border-red-400 @enderror">
        <p class="mt-1 text-xs text-slate-500">Separa las tecnologías con comas.</p>
        @error('stack')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Estado --}}
    <div>
        <label for="estado" class="block text-sm font-medium text-slate-700 mb-1">Estado</label>
        <select name="estado" id="estado"
                class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition-colors
                       @error('estado') border-red-400 @enderror">
            <option value="">Selecciona un estado</option>
            @foreach ($estados as $estado)
                <option value="{{ $estado }}"
                    {{ old('estado', $proyecto->estado ?? '') === $estado ? 'selected' : '' }}>
                    {{ $estado }}
                </option>
            @endforeach
        </select>
        @error('estado')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Resumen --}}
    <div>
        <label for="resumen" class="block text-sm font-medium text-slate-700 mb-1">Resumen</label>
        <textarea name="resumen" id="resumen" rows="5"
                  placeholder="Describe de qué trata el proyecto, qué aprendiste, qué problemas resolviste..."
                  class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition-colors resize-y
                         @error('resumen') border-red-400 @enderror">{{ old('resumen', $proyecto->resumen ?? '') }}</textarea>
        @error('resumen')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Botones --}}
    <div class="flex items-center gap-3 pt-2">
        <button type="submit"
                class="inline-flex items-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 transition-colors">
            {{ isset($proyecto) && $proyecto->exists ? 'Guardar cambios' : 'Crear proyecto' }}
        </button>
        <a href="{{ isset($proyecto) && $proyecto->exists ? route('proyectos.show', $proyecto) : route('proyectos.index') }}"
           class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
            Cancelar
        </a>
    </div>
</div>
