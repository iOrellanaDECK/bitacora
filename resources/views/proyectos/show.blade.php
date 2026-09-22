<x-app-layout>
    <x-slot name="title">{{ $proyecto->titulo }}</x-slot>

    {{-- Breadcrumb --}}
    <a href="{{ route('proyectos.index') }}"
       class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-indigo-600 transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a proyectos
    </a>

    <article class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
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
                <span class="inline-block rounded-full px-3 py-1 text-xs font-medium {{ $badgeClasses }}">
                    {{ $proyecto->estado }}
                </span>

                <h1 class="mt-3 text-2xl font-bold text-gray-900">{{ $proyecto->titulo }}</h1>

                {{-- Etiquetas --}}
                @if ($proyecto->etiquetas->isNotEmpty())
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($proyecto->etiquetas as $etiqueta)
                            <a href="{{ route('proyectos.index', ['etiqueta' => $etiqueta->slug]) }}"
                               class="inline-block rounded-md bg-indigo-50 text-indigo-700 px-2.5 py-1 text-xs font-medium hover:bg-indigo-100 transition-colors">
                                {{ $etiqueta->nombre }}
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Stack --}}
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach (explode(',', $proyecto->stack) as $tech)
                        <span class="inline-block rounded-md bg-gray-100 text-gray-700 px-2.5 py-1 text-xs font-medium">
                            {{ trim($tech) }}
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Actions (only for owner) --}}
            @can('update', $proyecto)
                <div class="flex items-center gap-2">
                    <a href="{{ route('proyectos.edit', $proyecto) }}"
                       class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>

                    <form action="{{ route('proyectos.destroy', $proyecto) }}" method="POST"
                          onsubmit="return confirm('¿Eliminar este proyecto?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            @endcan
        </div>

        {{-- Resumen --}}
        <div class="mt-8 border-t border-gray-100 pt-6">
            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Resumen</h2>
            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $proyecto->resumen }}</p>
        </div>

        {{-- Meta --}}
        <div class="mt-8 border-t border-gray-100 pt-6 flex flex-wrap gap-6 text-xs text-gray-400">
            <span>Autor: {{ $proyecto->user->name }}</span>
            <span>Creado: {{ $proyecto->created_at->format('d M Y') }}</span>
            @if ($proyecto->updated_at->ne($proyecto->created_at))
                <span>Actualizado: {{ $proyecto->updated_at->format('d M Y') }}</span>
            @endif
        </div>
    </article>
</x-app-layout>
