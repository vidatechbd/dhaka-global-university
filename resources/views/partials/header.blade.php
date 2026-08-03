@php
    $homeSetting = \App\Models\HomepageSetting::firstOrCreate([]);
    $uniSetting = \App\Models\UniversitySetting::first();
@endphp

<!-- Top Bar -->
@if($homeSetting->show_top_bar)
<div class="bg-primaryDark text-white/80 py-2 text-xs sm:text-sm font-medium">
    <div class="container mx-auto px-4 md:px-6 flex flex-col sm:flex-row justify-between items-center">
        <div class="flex space-x-6 mb-2 sm:mb-0">
            @if($homeSetting->top_bar_email)
                <a href="mailto:{{ $homeSetting->top_bar_email }}" class="hover:text-white transition flex items-center gap-2">
                    <i class="ph ph-envelope-simple"></i> {{ $homeSetting->top_bar_email }}
                </a>
            @endif
            @if($homeSetting->top_bar_phone)
                <a href="tel:{{ $homeSetting->top_bar_phone }}" class="hover:text-white transition flex items-center gap-2">
                    <i class="ph ph-phone"></i> {{ $homeSetting->top_bar_phone }}
                </a>
            @endif
        </div>
        <div class="flex items-center space-x-6">
            @if($homeSetting->top_bar_links && count($homeSetting->top_bar_links) > 0)
                @foreach($homeSetting->top_bar_links as $link)
                    <a href="{{ $link['url'] ?? '#' }}" class="hover:text-white transition hidden md:block">{{ $link['title'] }}</a>
                @endforeach
            @endif
            
            <a href="{{ route('verification.form') }}" class="hover:text-white transition flex items-center gap-1 font-bold text-secondary">
                <i class="ph ph-certificate"></i> Certificate Verification
            </a>
            
             <a href="{{ route('marksheets.verification.form') }}" class="hover:text-white transition flex items-center gap-1 font-bold text-secondary">
                <i class="ph ph-file-text"></i> Marksheet Verification
            </a>
            
            @auth
                <a href="{{ url('/dashboard') }}" class="hover:text-white transition flex items-center gap-1 font-bold text-secondary">
                    <i class="ph ph-user"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="hover:text-white transition flex items-center gap-1 font-bold text-secondary">
                    <i class="ph ph-sign-in"></i> Log In
                </a>
                {{-- @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="hover:text-white transition flex items-center gap-1 font-bold text-secondary">
                        <i class="ph ph-user-plus"></i> Register
                    </a>
                @endif --}}
            @endauth
        </div>
    </div>
</div>
@endif

<!-- Main Navigation -->
<header class="bg-white shadow-md sticky top-0 z-50 transition-all duration-300" id="main-header">
    <div class="container mx-auto px-4 md:px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-3">
            @if($uniSetting && $uniSetting->logo)
                <img src="{{ asset($uniSetting->logo) }}" alt="Logo" class="w-12 h-12 object-contain">
            @else
                <div class="w-12 h-12 bg-primary flex items-center justify-center text-white font-serif font-bold text-xl rounded-none">
                    FU
                </div>
            @endif
            <div>
                <h1 class="text-xl md:text-2xl font-serif font-bold text-primary tracking-tight leading-none uppercase">
                    {{ $uniSetting->name ?? 'Feni University' }}
                </h1>
                <p class="text-[10px] md:text-xs text-slate-500 font-semibold uppercase tracking-widest mt-1">Center for Learning</p>
            </div>
        </a>

        <!-- Mobile Menu Btn -->
        <button id="mobile-menu-btn" class="lg:hidden text-primary p-2 hover:bg-slate-100 transition rounded-none border border-transparent">
            <i class="ph ph-list text-2xl"></i>
        </button>

@php
    $topLevelPages = \App\Models\Page::with('children')
        ->whereNull('parent_id')
        ->orderBy('sort_order')
        ->orderBy('title')
        ->get();
@endphp

        <!-- Desktop Nav -->
        <nav class="hidden lg:flex items-center space-x-6 font-semibold text-sm text-primary">
            <a href="/" class="hover:text-secondary transition py-2">Home</a>
            
            @foreach($topLevelPages as $tPage)
                @if($tPage->children->count() > 0)
                    <!-- Mega Menu Dropdown -->
                    <div class="group relative py-2">
                        <button class="hover:text-secondary transition flex items-center gap-1 uppercase tracking-wide">
                            {{ $tPage->title }} <i class="ph ph-caret-down text-xs transition-transform group-hover:rotate-180"></i>
                        </button>
                        <div class="absolute top-full left-0 lg:-left-24 mt-0 w-[550px] lg:w-[700px] bg-white border-t-4 border-secondary shadow-2xl p-8 grid grid-cols-1 md:grid-cols-2 gap-8 rounded-none opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            @foreach($tPage->children->sortBy('sort_order')->sortBy('title') as $childPage)
                                <div>
                                    <h4 class="text-primary font-serif font-bold text-sm border-b border-slate-200 pb-2 mb-4 flex items-center gap-2">
                                        {{-- <i class="ph-bold ph-graduation-cap text-secondary text-base"></i> --}}
                                        <a href="{{ route('page.show', $childPage->slug) }}" class="hover:text-secondary transition">
                                            {{ $childPage->title }}
                                        </a>
                                    </h4>
                                    
                                    @if($childPage->children->count() > 0)
                                        <ul class="space-y-3 font-normal text-xs text-slate-600">
                                            @foreach($childPage->children->sortBy('sort_order')->sortBy('title') as $grandChildPage)
                                                <li>
                                                    <a href="{{ route('page.show', $grandChildPage->slug) }}" class="hover:text-secondary transition block">
                                                        {{ $grandChildPage->title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Plain Link -->
                    <a href="{{ route('page.show', $tPage->slug) }}" class="hover:text-secondary transition uppercase tracking-wide py-2">
                        {{ $tPage->title }}
                    </a>
                @endif
            @endforeach

            <!-- News & Events Dropdown -->
            <div class="group relative py-2">
                <button class="hover:text-secondary transition flex items-center gap-1 uppercase tracking-wide">
                    News & Events <i class="ph ph-caret-down text-xs transition-transform group-hover:rotate-180"></i>
                </button>
                <div class="absolute top-full left-0 mt-0 w-64 bg-white border-t-4 border-primary shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 flex flex-col rounded-none z-50">
                    <a href="{{ route('news.index') }}" class="px-6 py-3 border-b border-slate-100 hover:bg-slate-50 hover:text-secondary transition text-slate-700 font-medium block">News</a>
                    <a href="{{ route('events.index') }}" class="px-6 py-3 border-b border-slate-100 hover:bg-slate-50 hover:text-secondary transition text-slate-700 font-medium block">Events</a>
                    <a href="{{ route('notices.index') }}" class="px-6 py-3 hover:bg-slate-50 hover:text-secondary transition text-slate-700 font-medium block">Notices</a>                </div>
            </div>

            <div class="pl-4 border-l border-slate-200 flex items-center gap-4" x-data="{ open: false, query: '{{ request('q') }}' }">
                <form action="{{ route('search') }}" method="GET" class="flex items-center relative" x-ref="searchForm">
                    <div class="relative flex items-center">
                        <input type="text" name="q" x-model="query"
                               x-show="open"
                               x-transition
                               x-ref="searchInput"
                               class="w-48 bg-slate-50 focus:bg-white text-xs text-slate-800 placeholder-slate-400 pl-3 pr-8 py-2 rounded-full border border-slate-200 focus:border-secondary focus:ring-1 focus:ring-secondary transition-all outline-none mr-1" 
                               placeholder="Search news & events...">
                        
                        <button type="button" @click="if (!open) { open = true; $nextTick(() => $refs.searchInput.focus()); } else if (query.trim().length > 0) { $refs.searchForm.submit(); } else { open = false; }" class="text-primary hover:text-secondary transition p-1 flex items-center justify-center">
                            <i :class="open ? 'ph ph-x text-xl' : 'ph ph-magnifying-glass text-xl'"></i>
                        </button>
                    </div>
                </form>
                <a href="{{ route('apply') }}" class="bg-secondary text-white px-6 py-2 rounded-none hover:bg-primary transition shadow-md font-bold uppercase tracking-wider text-xs whitespace-nowrap">Apply Now</a>
            </div>
        </nav>
    </div>

    <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-100 bg-white">
        <div class="container mx-auto px-4 py-4 flex flex-col space-y-2 font-medium text-primary">
            <a href="/" class="p-2 border-b border-slate-100">Home</a>
            @foreach($topLevelPages as $tPage)
                <a href="{{ $tPage->children->count() > 0 ? '#' : route('page.show', $tPage->slug) }}" class="p-2 border-b border-slate-100 block">{{ $tPage->title }}</a>
                @if($tPage->children->count() > 0)
                    <div class="pl-4 space-y-1">
                        @foreach($tPage->children->sortBy('sort_order')->sortBy('title') as $childPage)
                            <a href="{{ route('page.show', $childPage->slug) }}" class="p-1.5 text-xs text-slate-600 block border-b border-slate-50">&rarr; {{ $childPage->title }}</a>
                            @if($childPage->children->count() > 0)
                                <div class="pl-4 space-y-1">
                                    @foreach($childPage->children->sortBy('sort_order')->sortBy('title') as $grandChildPage)
                                        <a href="{{ route('page.show', $grandChildPage->slug) }}" class="p-1 text-[11px] text-slate-500 block border-b border-slate-50/50">&rarr;&rarr; {{ $grandChildPage->title }}</a>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endforeach
            <a href="{{ route('news.index') }}" class="p-2 border-b border-slate-100 block">News</a>
            <a href="{{ route('events.index') }}" class="p-2 border-b border-slate-100 block">Events</a>
            <a href="{{ route('notices.index') }}" class="p-2 border-b border-slate-100 block">Notices</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="p-2 bg-secondary text-white text-center mt-4 font-bold uppercase">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="p-2 bg-secondary text-white text-center mt-4 font-bold uppercase">Log In</a>
            @endauth
        </div>
    </div>
</header>
