<x-app-layout>
    <x-slot name="title">Proyectos</x-slot>

    {{-- Hero + Search --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Mis Proyectos</h1>
        <p class="mt-2 text-gray-600">Bitácora de lo que estoy construyendo, aprendiendo y experimentando.</p>

        {{-- Search & Filter Bar --}}
        <form method="GET" action="{{ route('proyectos.index') }}" class="mt-6 flex flex-col sm:flex-row gap-3">
            <input type="text" name="buscar" value="{{ request('buscar') }}"
                   placeholder="Buscar por título, stack o resumen..."
                   class="flex-1 rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

            <select name="estado"
                    class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:w-44">
                <option value="">Todos los estados</option>
                @foreach (['En progreso', 'Completado', 'Pausado', 'Planeado'] as $e)
                    <option value="{{ $e }}" {{ request('estado') === $e ? 'selected' : '' }}>{{ $e }}</option>
                @endforeach
            </select>

            <select name="etiqueta"
                    class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:w-44">
                <option value="">Todas las etiquetas</option>
                @foreach ($etiquetas as $etiqueta)
                    <option value="{{ $etiqueta->slug }}" {{ request('etiqueta') === $etiqueta->slug ? 'selected' : '' }}>
                        {{ $etiqueta->nombre }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="rounded-lg bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 transition-colors">
                Buscar
            </button>

            @if (request()->hasAny(['buscar', 'estado', 'etiqueta']))
                <a href="{{ route('proyectos.index') }}"
                   class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 transition-colors text-center">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    {{-- Grid de proyectos --}}
    @forelse ($proyectos as $proyecto)
        @if ($loop->first)
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @endif

        <a href="{{ route('proyectos.show', $proyecto) }}"
           class="group block rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md hover:border-indigo-300 transition-all">

            {{-- Estado badge --}}
            @php
                $badgeClasses = match($proyecto->estado) {
                    'Completado' => 'bg-green-100 text-green-700',
                    'En progreso' => 'bg-amber-100 text-amber-700',
                    'Pausado'     => 'bg-gray-100 text-gray-600',
                    'Planeado'    => 'bg-blue-100 text-blue-700',
                    default       => 'bg-gray-100 text-gray-600',
                };
            @endphp
            <span class="inline-block rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClasses }}">
                {{ $proyecto->estado }}
            </span>

            {{-- Título --}}
            <h2 class="mt-3 text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">
                {{ $proyecto->titulo }}
            </h2>

            {{-- Etiquetas (tags) --}}
            @if ($proyecto->etiquetas->isNotEmpty())
                <div class="mt-2 flex flex-wrap gap-1">
                    @foreach ($proyecto->etiquetas as $etiqueta)
                        <span class="inline-block rounded-md bg-indigo-50 text-indigo-600 px-2 py-0.5 text-xs font-medium">
                            {{ $etiqueta->nombre }}
                        </span>
                    @endforeach
                </div>
            @endif

            {{-- Stack --}}
            <div class="mt-2 flex flex-wrap gap-1.5">
                @foreach (explode(',', $proyecto->stack) as $tech)
                    <span class="inline-block rounded-md bg-gray-100 px-2 py-0.5 text-xs text-gray-600">
                        {{ trim($tech) }}
                    </span>
                @endforeach
            </div>

            {{-- Resumen --}}
            <p class="mt-3 text-sm text-gray-500 line-clamp-3">{{ $proyecto->resumen }}</p>

            {{-- Author --}}
            <p class="mt-3 text-xs text-gray-400">por {{ $proyecto->user->name }}</p>
        </a>

        @if ($loop->last)
            </div>
        @endif
    @empty
        <div class="text-center py-16">
            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-700">No se encontraron proyectos</h3>
            <p class="mt-1 text-sm text-gray-500">
                @if (request()->hasAny(['buscar', 'estado', 'etiqueta']))
                    Intenta con otros filtros.
                @else
                    Empieza agregando tu primer proyecto.
                @endif
            </p>
            @auth
                <a href="{{ route('proyectos.create') }}"
                   class="mt-6 inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 transition-colors">
                    Crear proyecto
                </a>
            @endauth
        </div>
    @endforelse
</x-app-layout>
