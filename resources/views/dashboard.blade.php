@php
    $layout = auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout';

    // Bar chart geometry (viewBox 0 0 600 220)
    $barMax = max(array_column($registrationTrend, 'count') ?: [1]);
    $barMax = $barMax > 0 ? $barMax : 1;
    $bars = [];
    foreach ($registrationTrend as $idx => $trend) {
        $x = 50 + ($idx * 90);
        $height = max(5, round(($trend['count'] / $barMax) * 130));
        $bars[] = [
            'x' => $x,
            'y' => 180 - $height,
            'h' => $height,
            'label' => $trend['month'],
            'count' => $trend['count'],
        ];
    }

    // Passing rate rounded gauge (SVG circle)
    $gaugeCircumference = 2 * pi() * 52;
    $gaugeOffset = $gaugeCircumference * (1 - ($passingRate / 100));
@endphp

<x-dynamic-component :component="$layout">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">{{ __('University Analytics') }}</h1>
                <p class="text-sm text-slate-500 font-medium mt-1">{{ __('Dhaka Global University — Academic Year 2025–2026') }}</p>
            </div>
            <div class="hidden sm:flex items-center gap-2 bg-white px-3 py-1.5 rounded-full border border-slate-200 shadow-sm">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-bold text-slate-600">System Live</span>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col gap-8 py-4">

        {{-- ── 6 Stat Cards Row ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">

            <!-- Card 1: Total Students -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center shadow-md shadow-blue-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4 4 4 0 004 4z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] text-indigo-700 bg-indigo-100/60 font-black px-2 py-0.5 rounded-full">Active</span>
                </div>
                <span class="text-3xl font-black text-slate-800 tracking-tight block">{{ number_format($totalStudents) }}</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mt-1">{{ __('Total Students') }}</span>
            </div>

            <!-- Card 2: Pending Students -->
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-100 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-600 text-white flex items-center justify-center shadow-md shadow-orange-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] text-orange-700 bg-orange-100/60 font-black px-2 py-0.5 rounded-full">Review</span>
                </div>
                <span class="text-3xl font-black text-slate-800 tracking-tight block">{{ number_format($pendingStudents) }}</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mt-1">{{ __('Pending Students') }}</span>
            </div>

            <!-- Card 3: Marksheets -->
            <div class="bg-gradient-to-br from-cyan-50 to-teal-50 border border-cyan-100 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-cyan-500 to-teal-600 text-white flex items-center justify-center shadow-md shadow-cyan-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] text-cyan-700 bg-cyan-100/60 font-black px-2 py-0.5 rounded-full">Issued</span>
                </div>
                <span class="text-3xl font-black text-slate-800 tracking-tight block">{{ number_format($totalMarksheets) }}</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mt-1">{{ __('Marksheets') }}</span>
            </div>

            <!-- Card 4: Certificates -->
            <div class="bg-gradient-to-br from-purple-50 to-fuchsia-50 border border-purple-100 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-fuchsia-600 text-white flex items-center justify-center shadow-md shadow-purple-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] text-purple-700 bg-purple-100/60 font-black px-2 py-0.5 rounded-full">Degrees</span>
                </div>
                <span class="text-3xl font-black text-slate-800 tracking-tight block">{{ number_format($totalCertificates) }}</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mt-1">{{ __('Certificates') }}</span>
            </div>

            <!-- Card 5: Passing Rate -->
            <div class="bg-gradient-to-br from-emerald-50 to-green-50 border border-emerald-100 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 text-white flex items-center justify-center shadow-md shadow-emerald-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] text-emerald-700 bg-emerald-100/60 font-black px-2 py-0.5 rounded-full">Academic</span>
                </div>
                <span class="text-3xl font-black text-slate-800 tracking-tight block">{{ $passingRate }}%</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mt-1">{{ __('Passing Rate') }}</span>
            </div>

            <!-- Card 6: Upcoming Events -->
            <div class="bg-gradient-to-br from-rose-50 to-pink-50 border border-rose-100 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 text-white flex items-center justify-center shadow-md shadow-rose-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] text-rose-700 bg-rose-100/60 font-black px-2 py-0.5 rounded-full">Events</span>
                </div>
                <span class="text-3xl font-black text-slate-800 tracking-tight block">{{ number_format($upcomingEvents) }}</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mt-1">{{ __('Upcoming Events') }}</span>
            </div>

        </div>

        {{-- ── Charts Row ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Student Admission Bar Chart (Left 2/3) -->
            <div class="lg:col-span-2 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-800 tracking-tight">Student Admission Chart</h2>
                        <span class="text-xs text-slate-400 font-medium">New student registration trend over the last 6 months</span>
                    </div>
                    <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-full px-3 py-1 uppercase tracking-wider">Live Registrations</span>
                </div>

                <div class="relative w-full" style="height: 240px;">
                    <svg viewBox="0 0 600 220" class="w-full h-full">
                        <!-- Gradients definition for premium bar styling -->
                        <defs>
                            <linearGradient id="barGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#3b82f6" />
                                <stop offset="100%" stop-color="#1d4ed8" />
                            </linearGradient>
                        </defs>

                        <!-- Horizontal Grid Lines -->
                        <line x1="40" y1="30" x2="580" y2="30" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="40" y1="70" x2="580" y2="70" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="40" y1="110" x2="580" y2="110" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="40" y1="150" x2="580" y2="150" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="40" y1="180" x2="580" y2="180" stroke="#e2e8f0" stroke-width="2" />

                        <!-- Bars (rounded tops via rx) -->
                        @foreach($bars as $bar)
                            <rect x="{{ $bar['x'] }}" y="{{ $bar['y'] }}" width="36" height="{{ $bar['h'] }}" rx="8" fill="url(#barGradient)" />
                            <text x="{{ $bar['x'] + 18 }}" y="{{ $bar['y'] - 8 }}" text-anchor="middle" font-size="10" fill="#475569" font-weight="900" font-family="sans-serif">{{ $bar['count'] }}</text>
                        @endforeach

                        <!-- X-Axis Labels -->
                        @foreach($bars as $bar)
                            <text x="{{ $bar['x'] + 18 }}" y="202" text-anchor="middle" font-size="10" fill="#64748b" font-weight="bold" font-family="sans-serif">{{ $bar['label'] }}</text>
                        @endforeach
                    </svg>
                </div>
            </div>

            <!-- Passing Rate Rounded Gauge (Right 1/3) -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow duration-300">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-800 tracking-tight mb-1">Passing Rate Chart</h2>
                    <span class="text-xs text-slate-400 font-medium block mb-4">Passing percentage of all academic marksheets</span>
                </div>

                <div class="relative mx-auto my-4" style="width: 170px; height: 170px;">
                    <svg viewBox="0 0 120 120" class="w-full h-full">
                        <!-- Gradients definitions for Gauge circle -->
                        <defs>
                            <linearGradient id="gaugeGradient" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#10b981" />
                                <stop offset="100%" stop-color="#059669" />
                            </linearGradient>
                        </defs>

                        <circle cx="60" cy="60" r="52" fill="none" stroke="#f1f5f9" stroke-width="14" />
                        <circle cx="60" cy="60" r="52" fill="none" stroke="url(#gaugeGradient)" stroke-width="14" stroke-linecap="round"
                            stroke-dasharray="{{ $gaugeCircumference }}"
                            stroke-dashoffset="{{ $gaugeOffset }}"
                            transform="rotate(-90 60 60)" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-black text-slate-850 tracking-tight">{{ $passingRate }}%</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">Passing</span>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-6 pt-4 border-t border-slate-100 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-3.5 h-3.5 rounded-full bg-emerald-500 shadow-sm"></span>
                        <span class="text-slate-600 font-bold">Passed</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-3.5 h-3.5 rounded-full bg-slate-200 shadow-sm"></span>
                        <span class="text-slate-400 font-bold">Failed / Draft</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-dynamic-component>
