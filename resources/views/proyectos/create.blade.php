<x-app-layout>
    <x-slot name="title">Nuevo proyecto</x-slot>

    <a href="{{ route('proyectos.index') }}"
       class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-indigo-600 transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a proyectos
    </a>

    <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Nuevo proyecto</h1>

        <form action="{{ route('proyectos.store') }}" method="POST">
            @csrf
            @include('proyectos._form')
        </form>
    </div>
</x-app-layout>
