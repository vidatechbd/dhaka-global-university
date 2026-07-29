@php
    $layout = auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout';
@endphp

<x-dynamic-component :component="$layout">
    <x-slot name="header">
        <div class="flex flex-col">
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">{{ __('University Dashboard') }}</h1>
            <p class="text-xs text-gray-400 font-medium mt-0.5">{{ __('Dhaka Global University — Academic Year 2025-2026') }}</p>
        </div>
    </x-slot>

    <div class="flex flex-col gap-6">
        <!-- Stat Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- 1. Total Students -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex flex-col">
                    <span class="text-3xl font-extrabold text-[#0d3b30] tracking-tight">12,480</span>
                    <span class="text-xs font-semibold text-gray-500 mt-1">{{ __('Total Students') }}</span>
                    <span class="text-[10px] text-green-600 font-bold flex items-center gap-1 mt-2">
                        ↑ +8.2%
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#e6f4f1] text-[#0d3b30] flex items-center justify-center text-xl font-bold">
                    👥
                </div>
            </div>

            <!-- 2. Faculty Members -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex flex-col">
                    <span class="text-3xl font-extrabold text-indigo-900 tracking-tight">648</span>
                    <span class="text-xs font-semibold text-gray-500 mt-1">{{ __('Faculty Members') }}</span>
                    <span class="text-[10px] text-indigo-600 font-bold flex items-center gap-1 mt-2">
                        ↑ +3.1%
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-950 flex items-center justify-center text-xl">
                    🎓
                </div>
            </div>

            <!-- 3. Active Courses -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex flex-col">
                    <span class="text-3xl font-extrabold text-amber-800 tracking-tight">342</span>
                    <span class="text-xs font-semibold text-gray-500 mt-1">{{ __('Active Courses') }}</span>
                    <span class="text-[10px] text-amber-600 font-bold flex items-center gap-1 mt-2">
                        ↑ +12.5%
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-800 flex items-center justify-center text-xl">
                    📖
                </div>
            </div>

            <!-- 4. Departments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex flex-col">
                    <span class="text-3xl font-extrabold text-purple-950 tracking-tight">24</span>
                    <span class="text-xs font-semibold text-gray-500 mt-1">{{ __('Departments') }}</span>
                    <span class="text-[10px] text-purple-600 font-bold flex items-center gap-1 mt-2">
                        0%
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-900 flex items-center justify-center text-xl">
                    🏛️
                </div>
            </div>

            <!-- 5. Pending Admissions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex flex-col">
                    <span class="text-3xl font-extrabold text-[#7c2d12] tracking-tight">1,205</span>
                    <span class="text-xs font-semibold text-gray-500 mt-1">{{ __('Pending Admissions') }}</span>
                    <span class="text-[10px] text-[#c2410c] font-bold flex items-center gap-1 mt-2">
                        ↑ +22.4%
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-[#ffedd5] text-[#7c2d12] flex items-center justify-center text-xl">
                    📋
                </div>
            </div>

            <!-- 6. Upcoming Events -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex flex-col">
                    <span class="text-3xl font-extrabold text-rose-900 tracking-tight">18</span>
                    <span class="text-xs font-semibold text-gray-500 mt-1{{ __('Upcoming Events') }}">{{ __('Upcoming Events') }}</span>
                    <span class="text-[10px] text-rose-600 font-bold flex items-center gap-1 mt-2">
                        ↓ -5.3%
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-900 flex items-center justify-center text-xl">
                    📅
                </div>
            </div>

            <!-- 7. Scholarships Awarded -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex flex-col">
                    <span class="text-3xl font-extrabold text-emerald-950 tracking-tight">384</span>
                    <span class="text-xs font-semibold text-gray-500 mt-1">{{ __('Scholarships Awarded') }}</span>
                    <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1 mt-2">
                        ↑ +15.8%
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-900 flex items-center justify-center text-xl">
                    🏆
                </div>
            </div>

            <!-- 8. Pass Rate -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex flex-col">
                    <span class="text-3xl font-extrabold text-teal-950 tracking-tight">87.6%</span>
                    <span class="text-xs font-semibold text-gray-500 mt-1">{{ __('Pass Rate') }}</span>
                    <span class="text-[10px] text-teal-600 font-bold flex items-center gap-1 mt-2">
                        ↑ +2.1%
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-900 flex items-center justify-center text-xl">
                    📈
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Line Chart (Student Enrollment Trend) -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-sm font-bold text-gray-800">{{ __('Student Enrollment Trend') }}</h3>
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ __('Jan — Sep 2026') }}</p>
                    </div>
                </div>

                <!-- Custom SVG Line Chart -->
                <div class="relative w-full h-64">
                    <svg viewBox="0 0 800 240" class="w-full h-full">
                        <!-- Horizontal Grid Lines -->
                        <line x1="50" y1="200" x2="780" y2="200" stroke="#f1f5f9" stroke-width="1.5" />
                        <line x1="50" y1="150" x2="780" y2="150" stroke="#f1f5f9" stroke-width="1" />
                        <line x1="50" y1="100" x2="780" y2="100" stroke="#f1f5f9" stroke-width="1" />
                        <line x1="50" y1="50" x2="780" y2="50" stroke="#f1f5f9" stroke-width="1" />

                        <!-- Line 1 (Enrollment Trend - Teal/Green) -->
                        <path d="M 50 110 L 140 105 L 230 95 L 320 90 L 410 85 L 500 80 L 590 75 L 680 70 L 770 60" 
                              fill="none" stroke="#0f766e" stroke-width="3" stroke-linecap="round" />
                        
                        <!-- Line 2 (Pending Trend - Orange Dotted) -->
                        <path d="M 50 200 L 140 195 L 230 195 L 320 190 L 410 190 L 500 188 L 590 185 L 680 183 L 770 180" 
                              fill="none" stroke="#ea580c" stroke-width="2" stroke-dasharray="4,4" />

                        <!-- Points for Line 1 -->
                        <circle cx="50" cy="110" r="5" fill="#0f766e" />
                        <circle cx="140" cy="105" r="5" fill="#0f766e" />
                        <circle cx="230" cy="95" r="5" fill="#0f766e" />
                        <circle cx="320" cy="90" r="5" fill="#0f766e" />
                        <circle cx="410" cy="85" r="5" fill="#0f766e" />
                        <circle cx="500" cy="80" r="5" fill="#0f766e" />
                        <circle cx="590" cy="75" r="5" fill="#0f766e" />
                        <circle cx="680" cy="70" r="5" fill="#0f766e" />
                        <circle cx="770" cy="60" r="5" fill="#0f766e" />

                        <!-- Points for Line 2 -->
                        <circle cx="50" cy="200" r="4" fill="#ea580c" />
                        <circle cx="140" cy="195" r="4" fill="#ea580c" />
                        <circle cx="230" cy="195" r="4" fill="#ea580c" />
                        <circle cx="320" cy="190" r="4" fill="#ea580c" />
                        <circle cx="410" cy="190" r="4" fill="#ea580c" />
                        <circle cx="500" cy="188" r="4" fill="#ea580c" />
                        <circle cx="590" cy="185" r="4" fill="#ea580c" />
                        <circle cx="680" cy="183" r="4" fill="#ea580c" />
                        <circle cx="770" cy="180" r="4" fill="#ea580c" />

                        <!-- X Axis Labels -->
                        <text x="50" y="220" text-anchor="middle" font-size="10" fill="#94a3b8" font-family="sans-serif">Jan</text>
                        <text x="140" y="220" text-anchor="middle" font-size="10" fill="#94a3b8" font-family="sans-serif">Feb</text>
                        <text x="230" y="220" text-anchor="middle" font-size="10" fill="#94a3b8" font-family="sans-serif">Mar</text>
                        <text x="320" y="220" text-anchor="middle" font-size="10" fill="#94a3b8" font-family="sans-serif">Apr</text>
                        <text x="410" y="220" text-anchor="middle" font-size="10" fill="#94a3b8" font-family="sans-serif">May</text>
                        <text x="500" y="220" text-anchor="middle" font-size="10" fill="#94a3b8" font-family="sans-serif">Jun</text>
                        <text x="590" y="220" text-anchor="middle" font-size="10" fill="#94a3b8" font-family="sans-serif">Jul</text>
                        <text x="680" y="220" text-anchor="middle" font-size="10" fill="#94a3b8" font-family="sans-serif">Aug</text>
                        <text x="770" y="220" text-anchor="middle" font-size="10" fill="#94a3b8" font-family="sans-serif">Sep</text>

                        <!-- Y Axis Labels -->
                        <text x="40" y="203" text-anchor="end" font-size="10" fill="#94a3b8" font-family="sans-serif">0</text>
                        <text x="40" y="153" text-anchor="end" font-size="10" fill="#94a3b8" font-family="sans-serif">3500</text>
                        <text x="40" y="103" text-anchor="end" font-size="10" fill="#94a3b8" font-family="sans-serif">7000</text>
                        <text x="40" y="53" text-anchor="end" font-size="10" fill="#94a3b8" font-family="sans-serif">10500</text>
                        <text x="40" y="15" text-anchor="end" font-size="10" fill="#94a3b8" font-family="sans-serif">14000</text>
                    </svg>
                </div>
            </div>

            <!-- Donut Chart (Students by Department) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-gray-800">{{ __('Students by Department') }}</h3>
                </div>

                <!-- Donut SVG -->
                <div class="relative flex items-center justify-center h-48 my-4">
                    <svg viewBox="0 0 36 36" class="w-40 h-40">
                        <!-- Background Circle -->
                        <circle cx="18" cy="18" r="15.915" fill="none" stroke="#f1f5f9" stroke-width="3" />
                        
                        <!-- Segments (stroke-dasharray="[length] [remaining]") -->
                        <!-- CSE (Teal: 40%) -->
                        <circle cx="18" cy="18" r="15.915" fill="none" stroke="#0d3b30" stroke-width="4.2"
                                stroke-dasharray="40 60" stroke-dashoffset="25" />

                        <!-- EEE (Indigo: 25%) -->
                        <circle cx="18" cy="18" r="15.915" fill="none" stroke="#4f46e5" stroke-width="4.2"
                                stroke-dasharray="25 75" stroke-dashoffset="85" />

                        <!-- BBA (Amber: 20%) -->
                        <circle cx="18" cy="18" r="15.915" fill="none" stroke="#f59e0b" stroke-width="4.2"
                                stroke-dasharray="20 80" stroke-dashoffset="60" />

                        <!-- Pharmacy (Rose: 15%) -->
                        <circle cx="18" cy="18" r="15.915" fill="none" stroke="#f43f5e" stroke-width="4.2"
                                stroke-dasharray="15 85" stroke-dashoffset="40" />
                    </svg>
                </div>

                <!-- Legend Grid -->
                <div class="grid grid-cols-2 gap-2 text-xs font-semibold text-gray-500">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#0d3b30]"></span>
                        <span>CSE (40%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-indigo-600"></span>
                        <span>EEE (25%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <span>BBA (20%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        <span>Pharmacy (15%)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
