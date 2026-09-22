<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Bitácora' }} — {{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="rounded-lg bg-green-50 border border-green-200 p-4 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="border-t border-gray-200 mt-auto">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-gray-500">
                    Hecho con Laravel {{ app()->version() }} por
                    <a href="https://github.com/iOrellanaDECK" target="_blank"
                       class="text-indigo-600 hover:underline">Ismael Orellana Castillo</a>
                </div>
            </footer>
        </div>
    </body>
</html>
