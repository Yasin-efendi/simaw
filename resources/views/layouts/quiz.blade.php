<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kuis SD') }} - {{ $quiz->title ?? 'Kuis' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <!-- Header Minimal untuk Kuis -->
    <header class="bg-white/80 backdrop-blur-sm shadow-sm sticky top-0 z-40">
        <div class="max-w-4xl mx-auto py-4 px-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-3xl">🎓</span>
                <div>
                    <h1 class="text-lg font-bold text-purple-700">Kuis SD</h1>
                    <p class="text-xs text-gray-500">Platform Latihan Soal</p>
                </div>
            </div>
            <div class="text-sm text-gray-600">
                <span class="font-semibold">{{ $quiz->meeting->topic->subject->grade->name ?? '' }}</span>
                <span class="mx-2">•</span>
                <span>{{ $quiz->meeting->topic->subject->name ?? '' }}</span>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>