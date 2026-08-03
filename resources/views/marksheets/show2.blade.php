@php
    $semestersData = $marksheet->semesters ?: [];
    $uniName    = $setting->name    ?? 'Feni University';
    $uniAddress = $setting->address ?? 'Trunk Road, Feni-3900, Bangladesh';
    $logoPath   = ($setting->logo ?? null) ? asset($setting->logo) : null;

    $contactEmail = collect($setting->contacts ?? [])->firstWhere('type', 'Email')['value'] ?? 'contact@dhakaglobal.university';
    $contactWeb   = collect($setting->social_medias ?? [])->firstWhere('platform', 'Website')['url']
                    ?? collect($setting->social_medias ?? [])->first()['url']
                    ?? 'https://dhakaglobal.university';

    // Points mapping helper
    if (!function_exists('getGradePoint')) {
        function getGradePoint($grade) {
            $grade = strtoupper(trim($grade));
            return match($grade) {
                'A+' => 4.00,
                'A'  => 3.75,
                'A-' => 3.50,
                'B+' => 3.25,
                'B'  => 3.00,
                'B-' => 2.75,
                'C+' => 2.50,
                'C'  => 2.25,
                'D'  => 2.00,
                'F'  => 0.00,
                default => 0.00
            };
        }
    }

    // Dynamic calculations for GPA and CGPA per semester
    $calculatedSemesters = [];
    $totalGPPointsSum = 0;
    $totalCreditsSum = 0;

    foreach ($semestersData as $sem) {
        $courses = $sem['courses'] ?? [];
        $termGPPoints = 0;
        $termCredits = 0;

        foreach ($courses as $course) {
            $cr = floatval($course['credit'] ?? 0);
            $gr = $course['grade'] ?? '';
            $gp = getGradePoint($gr);
            $courseGP = $cr * $gp;

            $termGPPoints += $courseGP;
            $termCredits += $cr;
        }

        $termGPA = $termCredits > 0 ? ($termGPPoints / $termCredits) : floatval($sem['year_cgp'] ?? 0);
        
        $totalGPPointsSum += $termGPPoints;
        $totalCreditsSum += $termCredits;
        $termCGPA = $totalCreditsSum > 0 ? ($totalGPPointsSum / $totalCreditsSum) : floatval($sem['year_cgp'] ?? 0);

        $calculatedSemesters[] = [
            'year' => $sem['year'] ?? '',
            'courses' => $courses,
            'gpa' => number_format($termGPA, 2),
            'cgpa' => number_format($termCGPA, 2),
        ];
    }

    // Overall summary fallbacks
    $requiredCredits = $marksheet->credit_total ?: 153;
    $creditsCompleted = $marksheet->credit_completed ?: $totalCreditsSum;
    $finalCGPA = $marksheet->result ?: (count($calculatedSemesters) > 0 ? end($calculatedSemesters)['cgpa'] : '0.00');
    $dateOfIssue = $marksheet->created_at ? $marksheet->created_at->format('d M Y') : date('d M Y');

    // Page-based chunking logic
    $totalSemesters = count($calculatedSemesters);
    $pages = [];
    
    if ($totalSemesters <= 3) {
        // Fits on a single page
        $pages[] = [
            'semesters' => $calculatedSemesters,
            'is_first' => true,
            'is_last' => true,
            'page_no' => 1
        ];
    } else {
        // Page 1 gets first 3 semesters
        $pages[] = [
            'semesters' => array_slice($calculatedSemesters, 0, 3),
            'is_first' => true,
            'is_last' => false,
            'page_no' => 1
        ];
        
        // Remaining semesters go to page 2 (and onwards if more chunks)
        $remaining = array_slice($calculatedSemesters, 3);
        $chunks = array_chunk($remaining, 4); // 4 semesters per page for subsequent pages
        foreach ($chunks as $idx => $chunk) {
            $pages[] = [
                'semesters' => $chunk,
                'is_first' => false,
                'is_last' => ($idx === count($chunks) - 1),
                'page_no' => $idx + 2
            ];
        }
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Official Academic Transcript - {{ $marksheet->student?->name ?? $marksheet->student_name ?? '' }}</title>
    
    @if($setting && $setting->favicon)
        <link rel="shortcut icon" href="{{ asset($setting->favicon) }}" type="image/x-icon">
        <link rel="icon" href="{{ asset($setting->favicon) }}" type="image/x-icon">
    @endif

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        
        /* Printable exact layout */
        @media print {
            body, html {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                overflow: visible !important;
            }
            body * { visibility: hidden; }
            .no-print { display: none !important; }
            
            .print-page {
                visibility: visible !important;
                position: relative !important;
                width: 210mm !important;
                height: 297mm !important;
                page-break-after: always !important;
                margin: 0 !important;
                padding: 10mm 15mm !important;
                box-shadow: none !important;
                border: none !important;
                box-sizing: border-box !important;
            }
            .print-page * { visibility: visible !important; }
            @page { size: A4 portrait; margin: 0; }
        }
    </style>
</head>
<body class="bg-[#F0E8EE] min-h-screen flex flex-col items-center justify-center p-6 text-black">
    
    <!-- Top toolbar & Action Buttons -->
    {{-- <div class="flex items-center gap-4 mb-6 no-print max-w-[210mm] w-full justify-between">
        <div class="flex items-center gap-2">
            <span class="bg-emerald-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-800 text-sm font-semibold">Verified Academic Document (Official Layout)</span>
        </div>
        
        <div class="flex items-center gap-3">
            <button onclick="window.print()"
                    class="bg-[#072740] hover:bg-[#051c2e] text-white px-5 py-2 rounded-full font-bold transition flex items-center gap-2 shadow-md text-xs cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print / Save PDF
            </button>
        </div>
    </div> --}}

    <!-- Multi-page stack container -->
    <div class="flex flex-col gap-8 no-print:w-[210mm]">
        @foreach($pages as $page)
            <div class="print-page bg-white relative shadow-2xl overflow-hidden flex flex-col justify-between"
                 style="width: 210mm; height: 297mm; padding: 10mm 15mm; box-sizing: border-box;">
                
                {{-- Centered Watermark --}}
                <div class="absolute inset-0 z-0 flex justify-center items-center pointer-events-none" style="opacity: 0.05;">
                    @if($logoPath)
                        <img src="{{ $logoPath }}" alt="Watermark" class="w-[450px] h-auto">
                    @else
                        @php
                            $words = explode(' ', $uniName);
                            $acronym = '';
                            foreach ($words as $w) {
                                $acronym .= strtoupper(substr($w, 0, 1));
                            }
                        @endphp
                        <span style="font-size: 140px; font-weight: 900; color: #072740; transform: rotate(-30deg); letter-spacing: -2px;">{{ $acronym ?: 'FU' }}</span>
                    @endif
                </div>

                {{-- Page Content body --}}
                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div>
                        {{-- University Header Banner --}}
                        <div class="flex items-center justify-between pb-2 mb-4" style="border-bottom: 5px double #072740;">
                            <!-- Logo and Estd -->
                            <div class="flex flex-col items-center w-28">
                                @if($logoPath)
                                    <img src="{{ $logoPath }}" alt="FU Logo" class="h-16 w-auto object-contain">
                                @else
                                    <div class="w-14 h-14 bg-[#072740] text-white rounded-lg flex items-center justify-center font-bold text-xl">FU</div>
                                @endif
                                @if(str_contains(strtolower($uniName), 'feni'))
                                    <span class="text-[10px] font-bold mt-1 text-slate-700">Estd: 2012</span>
                                @endif
                            </div>
                            
                            <!-- Middle: University Branding -->
                            <div class="flex-1 text-center pr-4">
                                <h1 class="text-[34px] font-bold text-[#072740] leading-none mb-1 uppercase" style="letter-spacing: 0.5px;">
                                    {{ $uniName }}
                                </h1>
                                <p class="text-[12px] font-bold text-slate-800 leading-tight mb-0.5">{{ $uniAddress }}</p>
                                <p class="text-[11px] font-semibold text-slate-700 leading-tight">
                                    @php
                                        $webHost = parse_url($contactWeb, PHP_URL_HOST) ?: $contactWeb;
                                        $isSocial = preg_match('/(facebook|twitter|instagram|linkedin|youtube|pinterest|github)/i', $webHost);
                                        $displayDomain = ($isSocial || !$webHost) ? request()->getHost() : $webHost;
                                        $displayDomain = preg_replace('/^www\./i', '', $displayDomain);
                                        
                                        $isIpOrLocal = preg_match('/^(localhost|127\.0\.0\.1|::1|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})/i', $displayDomain);
                                        $finalDisplay = $isIpOrLocal ? $displayDomain : $displayDomain;
                                    @endphp
                                    {{ $finalDisplay }}
                                </p>
                            </div>
                        </div>

                        {{-- Layout parts --}}
                        @if($page['is_first'])
                            <!-- Subtitle: Official Academic Transcript -->
                            <div class="text-center mb-4">
                                <h2 class="text-[16px] font-bold border-b border-black inline-block px-4 pb-0.5 tracking-wide">
                                    Official Academic Transcript
                                </h2>
                            </div>

                            <!-- Two-column profile and grading system -->
                            <div class="flex justify-between items-start gap-4 mb-4">
                                <!-- Student Info Profile (Left) -->
                                <div class="w-[60%] text-[12px] leading-[1.4] space-y-1.5 pt-1">
                                    <div class="flex">
                                        <span class="w-20 font-bold">Name</span>
                                        <span class="w-4 font-bold">:</span>
                                        <span class="font-bold uppercase flex-1">{{ $marksheet->student?->name ?? $marksheet->student_name ?? '—' }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-20 font-bold">Program</span>
                                        <span class="w-4 font-bold">:</span>
                                        <span class="font-bold uppercase flex-1">{{ $marksheet->course_name ?? '—' }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-20 font-bold">ID No</span>
                                        <span class="w-4 font-bold">:</span>
                                        <span class="font-bold flex-1">{{ $marksheet->exam_roll ?? '—' }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-20 font-bold">Batch</span>
                                        <span class="w-4 font-bold">:</span>
                                        <span class="font-bold flex-1">{{ $marksheet->session ?? '15 th' }}</span>
                                    </div>
                                </div>

                                <!-- Grading System (Right) -->
                                <div class="w-[38%] border border-black p-1 bg-white shadow-sm">
                                    <h3 class="text-[9px] font-bold text-center border-b border-black pb-0.5 mb-0.5">Grading System</h3>
                                    <table class="w-full text-[8px] border-collapse leading-none">
                                        <thead>
                                            <tr class="border-b border-black font-bold">
                                                <th class="pb-0.5 text-left">Letter Grade</th>
                                                <th class="pb-0.5 text-center">Equivalent Marks</th>
                                                <th class="pb-0.5 text-right">Grade point</th>
                                            </tr>
                                        </thead>
                                        <tbody class="font-semibold text-slate-800">
                                            <tr><td class="py-0.5">A+</td><td class="text-center py-0.5">80% and Above</td><td class="text-right py-0.5">4.00</td></tr>
                                            <tr><td class="py-0.5">A</td><td class="text-center py-0.5">75% to less than 80%</td><td class="text-right py-0.5">3.75</td></tr>
                                            <tr><td class="py-0.5">A-</td><td class="text-center py-0.5">70% to less than 75%</td><td class="text-right py-0.5">3.50</td></tr>
                                            <tr><td class="py-0.5">B+</td><td class="text-center py-0.5">65% to less than 70%</td><td class="text-right py-0.5">3.25</td></tr>
                                            <tr><td class="py-0.5">B</td><td class="text-center py-0.5">60% to less than 65%</td><td class="text-right py-0.5">3.00</td></tr>
                                            <tr><td class="py-0.5">B-</td><td class="text-center py-0.5">55% to less than 60%</td><td class="text-right py-0.5">2.75</td></tr>
                                            <tr><td class="py-0.5">C+</td><td class="text-center py-0.5">50% to less than 55%</td><td class="text-right py-0.5">2.50</td></tr>
                                            <tr><td class="py-0.5">C</td><td class="text-center py-0.5">45% to less than 50%</td><td class="text-right py-0.5">2.25</td></tr>
                                            <tr><td class="py-0.5">D</td><td class="text-center py-0.5">40% to less than 45%</td><td class="text-right py-0.5">2.00</td></tr>
                                            <tr><td class="py-0.5">F</td><td class="text-center py-0.5">Less than 40%</td><td class="text-right py-0.5">0.00</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- List of Completed Courses Heading -->
                            <div class="text-center mb-3">
                                <h3 class="text-[14px] font-bold underline underline-offset-2">Courses Completed at {{ $uniName }}</h3>
                            </div>
                        @endif

                        {{-- Semester Tables --}}
                        <div class="space-y-4">
                            @foreach($page['semesters'] as $sem)
                                <div>
                                    <h4 class="text-[10px] font-bold mb-0.5 uppercase tracking-wide">
                                        {{ $sem['year'] }}
                                    </h4>
                                    
                                    <table class="w-full border-collapse border border-black text-[9px] bg-white">
                                        <thead>
                                            <tr class="bg-slate-50 text-[9px] border-b border-black font-bold">
                                                <th class="border-r border-black py-0.5 px-1 text-center w-[15%]">Course Code</th>
                                                <th class="border-r border-black py-0.5 px-2 text-left">Course Title</th>
                                                <th class="border-r border-black py-0.5 px-1 text-center w-[10%]">Cr. Hr</th>
                                                <th class="border-r border-black py-0.5 px-1 text-center w-[10%]">Grade</th>
                                                <th class="border-r border-black py-0.5 px-1 text-center w-[10%]">Point</th>
                                                <th class="py-0.5 px-1 text-center w-[10%]">G.P</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sem['courses'] as $course)
                                                @php
                                                    $credit = floatval($course['credit'] ?? 0);
                                                    $grade = $course['grade'] ?? '—';
                                                    $pt = getGradePoint($grade);
                                                    $gp = $credit * $pt;
                                                @endphp
                                                <tr class="border-b border-black text-slate-900">
                                                    <td class="border-r border-black py-0.5 px-1 text-center font-mono">{{ $course['code'] ?? '—' }}</td>
                                                    <td class="border-r border-black py-0.5 px-2 text-left uppercase">{{ $course['title'] ?? '—' }}</td>
                                                    <td class="border-r border-black py-0.5 px-1 text-center">{{ number_format($credit, 2) }}</td>
                                                    <td class="border-r border-black py-0.5 px-1 text-center font-bold">{{ $grade }}</td>
                                                    <td class="border-r border-black py-0.5 px-1 text-center">{{ number_format($pt, 2) }}</td>
                                                    <td class="py-0.5 px-1 text-center font-semibold">{{ number_format($gp, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Semester GPA / CGPA Bar -->
                                    <div class="flex justify-end text-[10px] font-bold border-l border-r border-b border-black py-0.5 px-3 bg-slate-50/50">
                                        <div class="flex gap-8">
                                            <span>GPA: {{ $sem['gpa'] }}</span>
                                            <span>CGPA: {{ $sem['cgpa'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Footer & Signatures Block --}}
                    <div class="mt-4">
                        <div class="flex justify-between items-end pb-1 border-b border-slate-300">
                            <!-- Left Block: Final GPA/CGPA summary (Last Page Only) -->
                            <div class="w-[50%] text-[11px] leading-[1.3] space-y-0.5">
                                @if($page['is_last'])
                                    <div class="flex">
                                        <span class="w-32 font-bold">Required Credits</span>
                                        <span class="w-4 font-bold">:</span>
                                        <span class="font-bold">{{ $requiredCredits }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-32 font-bold">Credits Completed</span>
                                        <span class="w-4 font-bold">:</span>
                                        <span class="font-bold">{{ $creditsCompleted }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-32 font-bold">CGPA</span>
                                        <span class="w-4 font-bold">:</span>
                                        <span class="font-bold text-[#072740] text-sm">{{ $finalCGPA }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="w-32 font-bold">Date of Issue</span>
                                        <span class="w-4 font-bold">:</span>
                                        <span class="font-bold">{{ $dateOfIssue }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Right Block: Signature line -->
                            <div class="w-[45%] text-center flex flex-col items-center">
                                @if($page['is_last'])
                                    <!-- QR Code for verification -->
                                    <div class="flex flex-col items-center mb-2 no-print self-start ml-4">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=70x70&data={{ urlencode(route('marksheets.verify2', $marksheet)) }}" alt="QR Code" class="w-12 h-12 border border-gray-300 p-0.5 bg-white">
                                        <p class="text-[6px] font-bold mt-0.5 text-gray-500">SCAN TO VERIFY</p>
                                    </div>
                                @endif
                                
                                <div class="h-10 flex items-end justify-center mb-1">
                                    @if($setting->marksheet_controller_signature)
                                        <img src="{{ asset($setting->marksheet_controller_signature) }}" alt="Controller Signature" class="max-h-full object-contain">
                                    @else
                                        <!-- Fallback placeholder -->
                                        <div class="w-24 border-b border-dashed border-slate-400 h-[1px]"></div>
                                    @endif
                                </div>
                                {{-- <span class="block border-t border-black w-full pt-1 text-[11px] font-bold tracking-wide leading-none">
                                    ({{ $setting->controller_of_examinations ?? 'Muhammad Harun Al-Rashid' }})
                                </span> --}}
                                <span class="block border-t border-black w-max p-3  text-[10px] font-bold text-slate-700 mt-0.5 leading-none">
                                    Controller of Examination
                                </span>
                            </div>
                        </div>

                        <!-- Footer metadata -->
                        <div class="flex justify-between items-center text-[9px] text-slate-500 font-semibold pt-1">
                            <span>Verification Link: {{ route('marksheets.verify2', $marksheet) }}</span>
                            <span class="font-bold text-slate-800 text-[10px]">Page {{ $page['page_no'] }}</span>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

</body>
</html>
