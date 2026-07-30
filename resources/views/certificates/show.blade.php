@php
    $semestersData = $certificate->semesters ?: [];
    $uniName    = $setting->name    ?? 'Dhaka Global University';
    $uniAddress = $setting->address ?? 'Purbachal Model Town, Uttara, Dhaka, Bangladesh';
    $logoPath   = ($setting->logo ?? null) ? asset($setting->logo) : null;

    // Extract first email & web from contacts/social_medias for the footer
    $contactEmail = collect($setting->contacts ?? [])->firstWhere('type', 'Email')['value'] ?? 'contact@dhakaglobal.university';
    $contactWeb   = collect($setting->social_medias ?? [])->firstWhere('platform', 'Website')['url']
                    ?? collect($setting->social_medias ?? [])->first()['url']
                    ?? 'https://dhakaglobal.university';
@endphp

@php
    $isDynamicLayout = true;
    $layoutComponent = auth()->user()->hasRole('Student') ? 'layouts.app' : 'layouts.admin';
@endphp

<x-dynamic-component :component="auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout'">

    <style>
        /* ─── Print overrides: hide everything except the A4 document ─── */
        @media print {
            body, html {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                overflow: visible !important;
            }
            body * { visibility: hidden; }
            #sidebar, header, .no-print, nav, aside { display: none !important; }
            #printable-transcript,
            #printable-transcript * { visibility: visible !important; }
            #printable-transcript {
                position: fixed !important;
                left: 0 !important;
                top: 0 !important;
                width: 210mm !important;
                min-height: 297mm !important;
                margin: 0 !important;
                padding: 10mm 15mm !important;
                box-shadow: none !important;
                border: none !important;
            }
            @page { size: A4 portrait; margin: 0; }
        }
    </style>

    <div class="py-6 max-w-5xl mx-auto w-full">

        {{-- ── Top Toolbar ── --}}
        <div class="flex items-center justify-between mb-6 no-print">
            <a href="{{ route('certificates.index') }}"
               class="text-sm font-semibold text-gray-600 hover:text-gray-900 flex items-center gap-1">
                &larr; Back to Certificates
            </a>
            <button onclick="window.print()"
                    class="bg-[#0a3a60] hover:bg-[#072740] text-white px-5 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 shadow-md text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print / Save as PDF
            </button>
        </div>

        {{-- ════════════════════════════════════════════
             A4 ACADEMIC TRANSCRIPT DOCUMENT
             Exact replica of the provided HTML design
             ════════════════════════════════════════════ --}}
        <div id="printable-transcript"
             class="bg-white relative mx-auto overflow-hidden print:w-full print:h-full print:absolute print:top-0 print:left-0 shadow-xl"
             style="width:210mm; min-height:297mm; padding:10mm 15mm; font-family:'Times New Roman',Times,serif; box-sizing:border-box;">

            {{-- ── Watermark ── --}}
            <div class="absolute inset-0 z-0 flex justify-center items-center pointer-events-none"
                 style="opacity:0.08;">
                @if($logoPath)
                    <img src="{{ $logoPath }}" alt="Watermark" style="width:500px; height:auto;">
                @else
                    <span style="font-size:120px; font-weight:900; color:#0a3a60; letter-spacing:-4px; white-space:nowrap; transform:rotate(-30deg);">
                        {{ strtoupper(substr($uniName, 0, 3)) }}
                    </span>
                @endif
            </div>
            {{-- ── Document Body ── --}}
            <div class="relative z-10 text-black flex flex-col justify-between" style="min-height: 277mm;">
                <div>

                    {{-- ── University Header ── --}}
                    <div class="flex items-center justify-between mb-2">
                        {{-- Left Logo --}}
                        <div class="w-20">
                            @if($logoPath)
                                <img src="{{ $logoPath }}" alt="Logo" class="w-18 h-auto">
                            @else
                                <div style="width:72px;height:72px;display:flex;align-items:center;justify-content:center;background:#0a3a60;color:white;font-size:28px;border-radius:4px;">🎓</div>
                            @endif
                        </div>

                        {{-- Center Title --}}
                        <div class="flex-1 text-center">
                            <h1 class="text-[24px] font-bold leading-tight mb-0.5"
                                style="font-family:'Times New Roman',Times,serif;">
                                {{ $uniName }}
                            </h1>
                            <p class="text-[12px] font-bold leading-tight mb-0.5">{{ $uniAddress }}</p>
                            <h2 class="text-[14px] font-bold underline underline-offset-2 mt-1">ACADEMIC TRANSCRIPT</h2>
                        </div>

                        {{-- Right spacer --}}
                        <div class="w-20"></div>
                    </div>

                    {{-- ── Student Information ── --}}
                    <div class="mb-3 text-[12px] leading-[1.3] w-[85%]">

                        <div class="flex mb-[1px]">
                            <div class="w-48 font-bold">Student's Name</div>
                            <div class="w-4 font-bold">:</div>
                            <div class="font-bold uppercase">{{ $certificate->student->name ?? '—' }}</div>
                        </div>

                        <div class="flex mb-[1px]">
                            <div class="w-48 font-bold">Father's Name</div>
                            <div class="w-4 font-bold">:</div>
                            <div class="font-bold uppercase">{{ $certificate->father_name ?? '—' }}</div>
                        </div>

                        <div class="flex mb-[1px]">
                            <div class="w-48 font-bold">Mother's Name</div>
                            <div class="w-4 font-bold">:</div>
                            <div class="font-bold uppercase">{{ $certificate->mother_name ?? '—' }}</div>
                        </div>

                        <div class="flex mb-[1px]">
                            <div class="w-48 font-bold">Name of Course</div>
                            <div class="w-4 font-bold">:</div>
                            <div class="font-bold">{{ $certificate->course_name ?? '—' }}</div>
                        </div>

                        <div class="flex mb-[1px]">
                            <div class="w-48 font-bold">Exam. Roll</div>
                            <div class="w-4 font-bold">:</div>
                            <div class="font-bold">{{ $certificate->exam_roll ?? '—' }}</div>
                        </div>

                        <div class="flex mb-[1px]">
                            <div class="w-48 font-bold">Registration No - Session</div>
                            <div class="w-4 font-bold">:</div>
                            <div class="font-bold">{{ $certificate->reg_no ?? '—' }}{{ $certificate->session ? ' - '.$certificate->session : '' }}</div>
                        </div>

                        <div class="flex mb-[1px]">
                            <div class="w-48 font-bold">Subject/Department Name</div>
                            <div class="w-4 font-bold">:</div>
                            <div class="font-bold">{{ $certificate->department ?? '—' }}</div>
                        </div>

                        <div class="flex mb-[1px]">
                            <div class="w-48 font-bold">Credit (Completed/Total)</div>
                            <div class="w-4 font-bold">:</div>
                            <div class="font-bold">
                                @if($certificate->credit_completed || $certificate->credit_total)
                                    {{ $certificate->credit_completed ?? '0' }}/{{ $certificate->credit_total ?? '0' }}
                                @else
                                    —
                                @endif
                            </div>
                        </div>

                        <div class="flex mb-[1px]">
                            <div class="w-48 font-bold">Result</div>
                            <div class="w-4 font-bold">:</div>
                            <div class="font-bold">{{ $certificate->result ?? '—' }}</div>
                        </div>

                    </div>

                    {{-- ── Academic Table ── --}}
                    <table class="w-full border-collapse border border-black text-[10px] mb-3"
                           style="line-height:1.15;">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border border-black py-1 px-1 font-bold text-center w-14">SEMESTER</th>
                                <th class="border border-black py-1 px-1 font-bold text-center w-20">COURSE CODE</th>
                                <th class="border border-black py-1 px-2 font-bold text-left">COURSE TITLE</th>
                                <th class="border border-black py-1 px-1 font-bold text-center w-14">CREDIT</th>
                                <th class="border border-black py-1 px-1 font-bold text-center w-14">GRADE</th>
                                <th class="border border-black py-1 px-1 font-bold text-center w-16">GPA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($semestersData as $sem)
                                @php
                                    $courses  = $sem['courses'] ?? [];
                                    $rowCount = count($courses);
                                @endphp
                                @foreach($courses as $idx => $course)
                                    <tr>
                                        @if($idx === 0)
                                            <td rowspan="{{ $rowCount }}"
                                                class="border border-black text-center font-bold align-middle">
                                                {{ $sem['name'] ?? '' }}
                                            </td>
                                        @endif
                                        <td class="border border-black text-center py-[1.5px] px-1">
                                            {{ $course['code'] ?? '' }}
                                        </td>
                                        <td class="border border-black px-2 py-[1.5px]">
                                            {{ $course['title'] ?? '' }}
                                        </td>
                                        <td class="border border-black text-center py-[1.5px] px-1">
                                            {{ $course['credit'] ?? '' }}
                                        </td>
                                        <td class="border border-black text-center py-[1.5px] px-1 font-bold">
                                            {{ $course['grade'] ?? '' }}
                                        </td>
                                        @if($idx === 0)
                                            <td rowspan="{{ $rowCount }}"
                                                class="border border-black text-center font-bold align-middle">
                                                {{ $sem['gpa'] ?? '' }}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="6" class="border border-black text-center py-4 text-gray-400 italic">
                                        No semester data available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>{{-- end top content --}}

                {{-- ── Signatures & Footer ── --}}
                <div>
                    <div class="flex justify-between items-end mt-4 pt-4">
                        <div class="text-center w-36 relative">
                            <div class="border-t border-black font-bold pt-1 text-[12px] italic">Prepared by</div>
                        </div>
                        <div class="text-center w-36 relative">
                            <div class="border-t border-black font-bold pt-1 text-[12px] italic">Compared by</div>
                        </div>
                        <div class="text-center w-48 relative">
                            <div class="border-t border-black font-bold pt-1 text-[12px] italic">Controller of Examinations</div>
                        </div>
                    </div>

                    <div class="text-center text-[10px] mt-2 border-t border-black pt-1 font-bold">
                        Address: {{ $uniAddress }}<br>
                        E-mail: {{ $contactEmail }}, Web: {{ $contactWeb }}
                    </div>
                </div>

            </div>{{-- end document body --}}
        </div>{{-- end #printable-transcript --}}
    </div>

    @if(request()->query('print'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    window.print();
                }, 500);
            });
        </script>
    @endif
</x-dynamic-component>
