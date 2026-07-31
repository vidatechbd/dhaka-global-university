@php
    $layout = auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout';

    // Bar chart geometry (viewBox 0 0 600 220)
    $barMax = max(array_column($registrationTrend, 'count') ?: [1]);
    $barMax = $barMax > 0 ? $barMax : 1;
    $bars = [];
    foreach ($registrationTrend as $idx => $trend) {
        $x = 40 + ($idx * 60);
        $height = max(2, round(($trend['count'] / $barMax) * 150));
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
        <div class="flex flex-col">
            <h1 class="text-2xl font-bold text-textclr-100 tracking-tight">{{ __('University Dashboard') }}</h1>
            <p class="text-xs text-textclr-200 font-medium mt-0.5">{{ __('Dhaka Global University — Academic Year 2025–2026') }}</p>
        </div>
    </x-slot>

    <div class="flex flex-col gap-6">

        {{-- ── 6 Stat Cards Row ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">

            <!-- Card 1: Total Students -->
            <div class="bg-[#e0edf7] border border-[#0a3a60] rounded-2xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-[#0a3a60] text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4 4 4 0 004 4z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] text-emerald-600 font-bold">↑ +8.2%</span>
                </div>
                <span class="text-2xl font-extrabold text-[#0a3a60] block">{{ number_format($totalStudents) }}</span>
                <span class="text-xs font-bold text-[#64748b]">{{ __('Total Students') }}</span>
            </div>

            <!-- Card 2: Pending Students -->
            <div class="bg-[#fff4eb] border border-orange-200 rounded-2xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-orange-600 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] text-emerald-600 font-bold">↑ +22.4%</span>
                </div>
                <span class="text-2xl font-extrabold text-orange-700 block">{{ number_format($pendingStudents) }}</span>
                <span class="text-xs font-bold text-slate-500">{{ __('Pending Students') }}</span>
            </div>

            <!-- Card 3: Marksheets -->
            <div class="bg-[#ebf8ff] border border-cyan-200 rounded-2xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-cyan-600 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] text-emerald-600 font-bold">↑ +12.5%</span>
                </div>
                <span class="text-2xl font-extrabold text-cyan-700 block">{{ number_format($totalMarksheets) }}</span>
                <span class="text-xs font-bold text-slate-500">{{ __('Marksheets') }}</span>
            </div>

            <!-- Card 4: Certificates -->
            <div class="bg-[#fdf3f8] border border-purple-200 rounded-2xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] text-emerald-600 font-bold">↑ +15.8%</span>
                </div>
                <span class="text-2xl font-extrabold text-purple-700 block">{{ number_format($totalCertificates) }}</span>
                <span class="text-xs font-bold text-slate-500">{{ __('Certificates') }}</span>
            </div>

            <!-- Card 5: Passing Rate -->
            <div class="bg-[#edf9f3] border border-emerald-200 rounded-2xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] text-emerald-600 font-bold">↑ +2.1%</span>
                </div>
                <span class="text-2xl font-extrabold text-emerald-700 block">{{ $passingRate }}%</span>
                <span class="text-xs font-bold text-slate-500">{{ __('Passing Rate') }}</span>
            </div>

            <!-- Card 6: Upcoming Events -->
            <div class="bg-[#fff0f3] border border-rose-200 rounded-2xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-[10px] text-rose-600 font-bold">Live</span>
                </div>
                <span class="text-2xl font-extrabold text-rose-700 block">{{ number_format($upcomingEvents) }}</span>
                <span class="text-xs font-bold text-slate-500">{{ __('Upcoming Events') }}</span>
            </div>

        </div>

        {{-- ── Charts Row ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Student Admission Bar Chart (Left 2/3) -->
            <div class="lg:col-span-2 bg-white border border-bgclr-300 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-base font-bold text-textclr-100">Student Admission</h2>
                        <span class="text-[10px] text-textclr-200">Last 6 months</span>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-full px-2.5 py-1">↑ Admissions</span>
                </div>

                <div class="relative w-full" style="height: 240px;">
                    <svg viewBox="0 0 600 220" class="w-full h-full">
                        <!-- Horizontal Grid Lines -->
                        <line x1="40" y1="30" x2="580" y2="30" stroke="#f1f3f4" stroke-width="1" />
                        <line x1="40" y1="70" x2="580" y2="70" stroke="#f1f3f4" stroke-width="1" />
                        <line x1="40" y1="110" x2="580" y2="110" stroke="#f1f3f4" stroke-width="1" />
                        <line x1="40" y1="150" x2="580" y2="150" stroke="#f1f3f4" stroke-width="1" />
                        <line x1="40" y1="180" x2="580" y2="180" stroke="#f1f3f4" stroke-width="1" />

                        <!-- Bars (rounded tops via rx) -->
                        @foreach($bars as $bar)
                            <rect x="{{ $bar['x'] }}" y="{{ $bar['y'] }}" width="30" height="{{ $bar['h'] }}" rx="6" fill="#0a3a60" />
                            <text x="{{ $bar['x'] + 15 }}" y="{{ $bar['y'] - 8 }}" text-anchor="middle" font-size="9" fill="#64748b" font-weight="bold" font-family="sans-serif">{{ $bar['count'] }}</text>
                        @endforeach

                        <!-- X-Axis Labels -->
                        @foreach($bars as $bar)
                            <text x="{{ $bar['x'] + 15 }}" y="200" text-anchor="middle" font-size="9" fill="#999" font-family="sans-serif">{{ $bar['label'] }}</text>
                        @endforeach
                    </svg>
                </div>
            </div>

            <!-- Passing Rate Rounded Gauge (Right 1/3) -->
            <div class="bg-white border border-bgclr-300 rounded-3xl p-6 shadow-sm flex flex-col">
                <h2 class="text-base font-bold text-textclr-100 mb-4">Passing Rate</h2>

                <div class="relative mx-auto my-2" style="width: 160px; height: 160px;">
                    <svg viewBox="0 0 120 120" class="w-full h-full">
                        <circle cx="60" cy="60" r="52" fill="none" stroke="#f1f3f4" stroke-width="14" />
                        <circle cx="60" cy="60" r="52" fill="none" stroke="#f7941d" stroke-width="14" stroke-linecap="round"
                            stroke-dasharray="{{ $gaugeCircumference }}"
                            stroke-dashoffset="{{ $gaugeOffset }}"
                            transform="rotate(-90 60 60)" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-extrabold text-[#0a3a60]">{{ $passingRate }}%</span>
                        <span class="text-[10px] font-bold text-slate-400 mt-0.5">Pass Rate</span>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-6 mt-4 pt-3 border-t border-bgclr-300 text-xs">
                    <div class="flex items-center gap-1.5">
                        <span class="inline-block w-3 h-3 rounded-full bg-[#f7941d]"></span>
                        <span class="text-textclr-200 font-semibold">Passed</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="inline-block w-3 h-3 rounded-full bg-[#f1f3f4]"></span>
                        <span class="text-textclr-200 font-semibold">Failed</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-dynamic-component>
