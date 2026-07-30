@php
    $uniSetting = \App\Models\UniversitySetting::first();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if($uniSetting)
        @if($uniSetting->meta_description)
            <meta name="description" content="{{ $uniSetting->meta_description }}">
        @endif
        @if($uniSetting->meta_keywords)
            <meta name="keywords" content="{{ $uniSetting->meta_keywords }}">
        @endif
        @if($uniSetting->meta_author)
            <meta name="author" content="{{ $uniSetting->meta_author }}">
        @endif
        @if($uniSetting->favicon)
            <link rel="shortcut icon" href="{{ asset($uniSetting->favicon) }}" type="image/x-icon">
            <link rel="icon" href="{{ asset($uniSetting->favicon) }}" type="image/x-icon">
        @endif
    @endif

    <title>{{ $uniSetting->meta_title ?? $uniSetting->name ?? config('app.name', 'Dhaka Global University') }}</title>
    
    <!-- Fonts: Serif for academic authority, Sans for readability -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- Tailwind CSS & AlpineJS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0a3a60',    // FU Navy blue
                        primaryDark: '#072740',
                        secondary: '#f7941d',  // FU Orange
                        secondaryDark: '#d97d10',
                        lightBg: '#f8fafc',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Merriweather', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #ffffff;
            color: #334155;
        }

        /* Modern Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; }
        ::-webkit-scrollbar-thumb:hover { background: #f7941d; }

        /* Mega Menu Transitions */
        .mega-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }
        .group-hover\:show-mega:hover .mega-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Native CSS Scroll-Driven Animations */
        @supports (animation-timeline: view()) {
            .reveal-on-scroll {
                animation: fade-in-up linear both;
                animation-timeline: view();
                animation-range: entry 5% cover 25%;
            }
            .reveal-delay-1 { animation-range: entry 10% cover 30%; }
            .reveal-delay-2 { animation-range: entry 15% cover 35%; }
        }

        /* Fallback for browsers that don't support CSS timeline yet (like Safari) */
        @supports not (animation-timeline: view()) {
            .reveal-on-scroll {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.8s ease, transform 0.8s ease;
            }
            .reveal-on-scroll.is-visible {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Notice Board Custom */
        .notice-list::-webkit-scrollbar { width: 4px; }
        .notice-list::-webkit-scrollbar-thumb { background: #0a3a60; }
    </style>
</head>
<body class="antialiased selection:bg-secondary selection:text-white">

    <!-- Include Header Partial -->
    @include('partials.header')

    <!-- Main Content Slot -->
    <main>
        {{ $slot }}
    </main>

    <!-- Include Footer Partial -->
    @include('partials.footer')

    <!-- Custom Success Popup Modal -->
    @if(session('success'))
        <div id="success-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all duration-300">
            <div class="bg-white rounded-none border border-slate-200 max-w-md w-full p-8 shadow-2xl relative transform scale-100 transition-transform duration-300 flex flex-col items-center text-center">
                
                <!-- Success Icon Wrapper with pulse -->
                <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mb-6 text-green-500 animate-bounce">
                    <i class="ph ph-check-circle text-4xl"></i>
                </div>

                <h3 class="text-xl font-serif font-bold text-primary mb-3">
                    Application Submitted!
                </h3>
                
                <p class="text-slate-500 text-xs leading-relaxed mb-6">
                    {{ session('success') }} Our admission department will review your academic records and contact you via email or phone shortly.
                </p>

                <button onclick="document.getElementById('success-modal').remove()" class="w-full py-2.5 bg-primary hover:bg-secondary text-white font-bold text-xs uppercase tracking-wider transition-colors shadow">
                    Continue
                </button>
            </div>
        </div>
    @endif

</body>
</html>
