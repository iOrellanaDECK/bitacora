<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bitácora') — Ismael Orellana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 text-slate-800 font-sans antialiased">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('proyectos.index') }}" class="text-xl font-semibold text-indigo-600 tracking-tight">
                    📓 Bitácora
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('proyectos.index') }}"
                       class="text-sm text-slate-600 hover:text-indigo-600 transition-colors">
                        Proyectos
                    </a>
                    <a href="{{ route('proyectos.create') }}"
                       class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Nuevo
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-800">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Content --}}
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-slate-200 mt-auto">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-slate-500">
            Hecho con Laravel {{ app()->version() }} por
            <a href="https://github.com/iOrellanaDECK" target="_blank"
               class="text-indigo-600 hover:underline">Ismael Orellana Castillo</a>
        </div>
    </footer>

</body>
</html>
