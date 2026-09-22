@extends('layouts.app')

@section('title', 'Proyectos')

@section('content')
    {{-- Hero --}}
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Mis Proyectos</h1>
        <p class="mt-2 text-slate-600">Bitácora de lo que estoy construyendo, aprendiendo y experimentando.</p>
    </div>

    {{-- Grid de proyectos --}}
    @forelse ($proyectos as $proyecto)
        @if ($loop->first)
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @endif

        <a href="{{ route('proyectos.show', $proyecto) }}"
           class="group block rounded-xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md hover:border-indigo-300 transition-all">

            {{-- Estado badge --}}
            @php
                $badgeClasses = match($proyecto->estado) {
                    'Completado' => 'bg-green-100 text-green-700',
                    'En progreso' => 'bg-amber-100 text-amber-700',
                    'Pausado'     => 'bg-slate-100 text-slate-600',
                    'Planeado'    => 'bg-blue-100 text-blue-700',
                    default       => 'bg-slate-100 text-slate-600',
                };
            @endphp
            <span class="inline-block rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badgeClasses }}">
                {{ $proyecto->estado }}
            </span>

            {{-- Título --}}
            <h2 class="mt-3 text-lg font-semibold text-slate-900 group-hover:text-indigo-600 transition-colors">
                {{ $proyecto->titulo }}
            </h2>

            {{-- Stack --}}
            <div class="mt-2 flex flex-wrap gap-1.5">
                @foreach (explode(',', $proyecto->stack) as $tech)
                    <span class="inline-block rounded-md bg-slate-100 px-2 py-0.5 text-xs text-slate-600">
                        {{ trim($tech) }}
                    </span>
                @endforeach
            </div>

            {{-- Resumen --}}
            <p class="mt-3 text-sm text-slate-500 line-clamp-3">{{ $proyecto->resumen }}</p>
        </a>

        @if ($loop->last)
            </div>
        @endif
    @empty
        <div class="text-center py-16">
            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-slate-700">Aún no hay proyectos</h3>
            <p class="mt-1 text-sm text-slate-500">Empieza agregando tu primer proyecto al portafolio.</p>
            <a href="{{ route('proyectos.create') }}"
               class="mt-6 inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Crear proyecto
            </a>
        </div>
    @endforelse
@endsection
