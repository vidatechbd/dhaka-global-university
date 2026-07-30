<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @php
        $uniSetting = \App\Models\UniversitySetting::first();
    @endphp
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if($uniSetting && $uniSetting->favicon)
            <link rel="shortcut icon" href="{{ asset($uniSetting->favicon) }}" type="image/x-icon">
            <link rel="icon" href="{{ asset($uniSetting->favicon) }}" type="image/x-icon">
        @endif

        <title>{{ $uniSetting->name ?? config('app.name', 'Dhaka Global University') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Alpine.js CDN -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-tr from-slate-900 via-slate-800 to-sky-950 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
        <!-- Floating decorative glowing background blobs -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-sky-600 rounded-full mix-blend-multiply filter blur-3xl opacity-25 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/3 right-1/4 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-15 animate-pulse" style="animation-delay: 4s;"></div>

        @php
            $setting = \App\Models\UniversitySetting::first();
            $logoPath = ($setting && $setting->logo) ? asset($setting->logo) : null;
            $uniName = $setting->name ?? 'Dhaka Global University';
        @endphp

        <div class="w-full max-w-md z-10 flex flex-col items-center">
            <!-- Logo Section -->
            <div class="mb-6 transform hover:scale-105 transition-transform duration-300">
                <a href="/" class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg border border-white/20 overflow-hidden">
                        @if($logoPath)
                            <img src="{{ $logoPath }}" alt="Logo" class="w-full h-full object-cover">
                        @else
                            <x-application-logo class="w-10 h-10 fill-current text-white" />
                        @endif
                    </div>
                    <span class="text-white font-semibold text-sm tracking-wider uppercase mt-2">{{ $uniName }}</span>
                </a>
            </div>

            <!-- Card Section -->
            <div class="w-full bg-white/95 backdrop-blur-lg shadow-2xl border border-white/20 rounded-2xl p-8 transition-all duration-300">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
