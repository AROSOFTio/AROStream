<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $appSettings['brand_name'] ?? config('app.name', 'AROStream') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @php
            $viteHot = public_path('hot');
            $viteManifest = public_path('build/manifest.json');
        @endphp
        @if (file_exists($viteHot) || file_exists($viteManifest))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
        @endif
        <style>
            input::placeholder,
            textarea::placeholder {
                color: #9ca3af;
                opacity: 1;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-100 flex">
            @include('layouts.sidebar')

            <div class="flex-1">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="p-6">
                    @if (session('status'))
                        <div class="mb-4 rounded bg-green-50 text-green-700 px-4 py-2">
                            {{ session('status') }}
                        </div>
                    @endif
                    @isset($slot)
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endisset
                </main>
            </div>
        </div>
    </body>
</html>
