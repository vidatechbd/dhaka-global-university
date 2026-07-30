@php
    $layout = auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout';
    
    // Fetch a few recent certificates for the transaction list
    $recentCertificates = \App\Models\Certificate::with('student')->latest()->take(3)->get();

    // 1. Process enrollment trend SVG path coordinates
    $counts = array_column($registrationTrend, 'count');
    $months = array_column($registrationTrend, 'month');
    $maxVal = max($counts);
    if ($maxVal <= 0) {
        $maxVal = 10;
    }
    
    // Map last 6 months to X [30, 470] and Y [40, 120] coordinates
    $points = [];
    foreach ($counts as $index => $c) {
        $x = 30 + ($index * 88);
        $y = 120 - (($c / $maxVal) * 80); // Y maps to [40, 120] range
        $points[] = ['x' => $x, 'y' => $y];
    }
    
    // Build line path
    $pathD = '';
    foreach ($points as $idx => $pt) {
        $pathD .= ($idx === 0 ? 'M ' : ' L ') . $pt['x'] . ' ' . $pt['y'];
    }
    
    // Build fill area path
    $fillD = "M 30 130 " . $pathD . " L 470 130 Z";
    
    // Last point for the pulsing node
    $lastPoint = end($points);

    // 2. Process department distribution shares
    $totalDeps = array_sum($departmentCounts);
    $displayDeps = [];
    if ($totalDeps > 0) {
        foreach ($departmentCounts as $name => $c) {
            $pct = round(($c / $totalDeps) * 100);
            $displayDeps[] = [
                'name' => strtoupper($name),
                'count' => $c,
                'percentage' => $pct,
            ];
        }
    } else {
        $displayDeps = [
            ['name' => 'CSE', 'count' => 0, 'percentage' => 0],
            ['name' => 'EEE', 'count' => 0, 'percentage' => 0],
            ['name' => 'BBA', 'count' => 0, 'percentage' => 0],
            ['name' => 'PHARM', 'count' => 0, 'percentage' => 0],
        ];
    }
@endphp

<x-dynamic-component :component="$layout">
    <x-slot name="header">
        <div class="flex flex-col">
            <h1 class="text-2xl font-bold text-textclr-100 tracking-tight">{{ __('University Dashboard') }}</h1>
            <p class="text-xs text-textclr-200 font-medium mt-0.5">{{ __('Dhaka Global University') }}</p>
        </div>
    </x-slot>

    <div class="flex flex-col gap-6">
        <!-- Top Banner Notification -->
        <div class="bg-bgclr-200/60 border border-bgclr-300/60 text-textclr-200 text-xs font-semibold py-2.5 px-4 rounded-full max-w-max shadow-sm">
            Open enrollment is active. Current database connections verified.
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Side: Large Total card & Transactions list -->
            <div class="lg:col-span-2 flex flex-col justify-between gap-6">
                <!-- 1. Total Balance Style card (Total Students) -->
                <div class="bg-primary-200/80 border border-primary-300/30 rounded-3xl p-8 flex flex-col justify-between h-56 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-primary-100/30 rounded-full -mr-16 -mt-16 filter blur-xl"></div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-textclr-100/70">{{ __('Total Enrolled Students') }}</span>
                        <h2 class="text-5xl font-extrabold text-textclr-100 tracking-tight mt-2 flex items-baseline gap-2">
                            <span class="text-2xl text-textclr-100/60 font-normal">S.</span>
                            {{ number_format($totalStudents) }}
                        </h2>
                    </div>
                    <div class="flex items-center justify-between z-10">
                        <span class="text-xs text-textclr-100/80 font-medium">Active academic registration database</span>
                        <div class="w-10 h-10 rounded-full bg-bgclr-100 flex items-center justify-center shadow-sm">
                            <span class="text-textclr-100 text-sm">🎓</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Transactions Style List (Recent Generated Certificates) -->
                <div class="bg-bgclr-200 border border-bgclr-300 rounded-3xl p-6 shadow-sm flex-1">
                    <h3 class="text-sm font-bold text-textclr-100 mb-5">{{ __('Recent Generated Transcripts') }}</h3>
                    <div class="space-y-4">
                        @forelse($recentCertificates as $certificate)
                            <div class="flex items-center justify-between p-3 bg-bgclr-100/50 border border-bgclr-300/30 rounded-2xl hover:border-bgclr-300 transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 bg-accent-200/20 text-accent-200 rounded-2xl flex items-center justify-center font-bold text-sm shrink-0 border border-accent-200/10">
                                        📜
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-sm text-textclr-100">{{ $certificate->student->name }}</span>
                                        <span class="text-xs text-textclr-200 font-medium">{{ $certificate->department ?: 'CSE' }} • Roll: {{ $certificate->exam_roll ?: '-' }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-extrabold text-sm text-textclr-100">GPA {{ $certificate->result ?: 'N/A' }}</span>
                                    <p class="text-[10px] text-textclr-200 font-semibold mt-0.5">{{ $certificate->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center text-textclr-200 text-xs italic">
                                No certificates generated yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Side: SVG Graph & Small widgets -->
            <div class="flex flex-col gap-6">
                <!-- 3. Trend Line Chart -->
                <div class="bg-bgclr-200 border border-bgclr-300 rounded-3xl p-6 shadow-sm flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-textclr-200 uppercase tracking-wider mb-2">{{ __('Enrollment Trend (Last 6 Months)') }}</h3>
                    </div>

                    <!-- Custom Dynamic SVG Line Chart -->
                    <div class="relative w-full h-40 my-2">
                        <svg viewBox="0 0 500 160" class="w-full h-full">
                            <!-- Background curve fill -->
                            <path d="{{ $fillD }}" fill="#B5D3D2" fill-opacity="0.25" />

                            <!-- Main trend wave line -->
                            <path d="{{ $pathD }}" fill="none" stroke="#587372" stroke-width="3.5" stroke-linecap="round" />

                            <!-- Highlighted Node (Accent color rose pink) -->
                            <circle cx="{{ $lastPoint['x'] }}" cy="{{ $lastPoint['y'] }}" r="7" fill="#FFB6C1" stroke="#985863" stroke-width="2.5" class="animate-pulse" />

                            <!-- Months labels dynamically positioned -->
                            @foreach($registrationTrend as $idx => $trend)
                                <text x="{{ 30 + ($idx * 88) }}" y="150" text-anchor="middle" font-size="9" fill="#787878" font-family="sans-serif">{{ $trend['month'] }}</text>
                            @endforeach
                        </svg>
                    </div>

                    <div class="pt-3 border-t border-bgclr-300 flex justify-between items-center text-xs">
                        <span class="text-textclr-200 font-semibold">Active registrations trend</span>
                        <span class="font-extrabold text-primary-300">Live Database</span>
                    </div>
                </div>

                <!-- 4. Small Widgets (Faculty & Pending) -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Faculty Members Card -->
                    <div class="bg-bgclr-200 border border-bgclr-300 rounded-2xl p-4 flex flex-col justify-between shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-textclr-200">Faculty</span>
                            <span class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center text-xs">👨‍🏫</span>
                        </div>
                        <div class="mt-4">
                            <span class="text-2xl font-extrabold text-textclr-100">{{ number_format($totalTeachers) }}</span>
                            <p class="text-[9px] text-textclr-200 font-bold mt-0.5">Active Teachers</p>
                        </div>
                    </div>

                    <!-- Pending Approvals Card -->
                    <div class="bg-bgclr-200 border border-bgclr-300 rounded-2xl p-4 flex flex-col justify-between shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-textclr-200">Pending</span>
                            <span class="w-6 h-6 rounded-full bg-accent-100/40 flex items-center justify-center text-xs">⌛</span>
                        </div>
                        <div class="mt-4">
                            <span class="text-2xl font-extrabold text-textclr-100">{{ number_format($pendingStudents) }}</span>
                            <p class="text-[9px] text-textclr-200 font-bold mt-0.5">Awaiting Review</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Investments Style Bottom Grid (Departments Overview) -->
        <div class="bg-bgclr-200 border border-bgclr-300 rounded-3xl p-6 shadow-sm w-full mt-2">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-sm font-bold text-textclr-100">Academic Departmental Distribution</h3>
                    <p class="text-[10px] text-textclr-200 font-medium mt-0.5">Share based on generated transcripts</p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($displayDeps as $dep)
                    <div class="bg-bgclr-100/50 border border-bgclr-300/40 rounded-2xl p-4 text-center hover:border-bgclr-300 transition">
                        <span class="inline-block px-2.5 py-1 bg-primary-100 text-primary-300 font-bold text-[9px] rounded-full uppercase tracking-wider">{{ $dep['name'] }}</span>
                        <h4 class="text-sm font-bold text-textclr-100 mt-3 truncate">{{ $dep['name'] }}</h4>
                        <p class="text-[10px] text-textclr-200 font-semibold mt-1">{{ $dep['percentage'] }}% share ({{ $dep['count'] }})</p>
                    </div>
                @endforeach

                <!-- View All Pill Card -->
                <a href="{{ route('certificates.index') }}" class="bg-primary-100 border border-primary-200 rounded-2xl p-4 flex flex-col items-center justify-center hover:bg-primary-200 transition cursor-pointer text-primary-300">
                    <span class="text-xs font-bold uppercase tracking-wider">View All</span>
                    <div class="w-8 h-8 rounded-full bg-bgclr-100 flex items-center justify-center mt-2 shadow-sm text-textclr-100">
                        &rarr;
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-dynamic-component>
