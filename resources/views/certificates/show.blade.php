@php
    $layout = auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout';
    
    // Default semester data if none stored
    $semestersData = $certificate->semesters ?: [
        [
            'name' => '1ST',
            'gpa' => '4.00',
            'courses' => [
                ['code' => '21011', 'title' => 'Engineering Drawing', 'credit' => '2', 'grade' => 'A+'],
                ['code' => '25911', 'title' => 'Mathematics-I', 'credit' => '4', 'grade' => 'A+'],
                ['code' => '21711', 'title' => 'Bangla-1', 'credit' => '3', 'grade' => 'A+'],
                ['code' => '21712', 'title' => 'English-1', 'credit' => '3', 'grade' => 'A+'],
                ['code' => '25912', 'title' => 'Physics-I', 'credit' => '4', 'grade' => 'A+'],
                ['code' => '28511', 'title' => 'Computer Office Application', 'credit' => '3', 'grade' => 'A+'],
            ]
        ],
        [
            'name' => '2ND',
            'gpa' => '3.90',
            'courses' => [
                ['code' => '26711', 'title' => 'Basic Electricity', 'credit' => '4', 'grade' => 'A'],
                ['code' => '21012', 'title' => 'Engineering Drawing-II', 'credit' => '2', 'grade' => 'A+'],
                ['code' => '21722', 'title' => 'English-II', 'credit' => '3', 'grade' => 'A+'],
                ['code' => '25812', 'title' => 'Physical Education & Life Skills Development', 'credit' => '2', 'grade' => 'A'],
            ]
        ]
    ];
@endphp

<x-dynamic-component :component="$layout">
    <style>
        @media print {
            body * { visibility: hidden; }
            #sidebar, header, .no-print, nav { display: none !important; }
            #transcript-printable, #transcript-printable * { visibility: visible; }
            #transcript-printable {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
                border: none;
            }
            body { background-color: white; }
            @page { size: A4 portrait; margin: 15mm; }
            .print-border { border-color: #000 !important; }
        }
    </style>

    <div class="py-6 max-w-4xl mx-auto w-full">
        <!-- Top Toolbar Actions -->
        <div class="flex items-center justify-between mb-6 no-print">
            <a href="{{ route('certificates.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 flex items-center gap-1">
                &larr; {{ __('Back to Certificates List') }}
            </a>
            <button onclick="window.print()" class="bg-[#0a3a60] hover:bg-[#072740] text-white px-5 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 shadow-md text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print / Save as PDF
            </button>
        </div>

        <!-- Printable Academic Transcript Document -->
        <div id="transcript-printable" class="bg-white p-10 mx-auto w-full max-w-[210mm] shadow-xl border border-gray-300 min-h-[297mm]">
            
            <!-- Header -->
            <div class="text-center mb-8 border-b-2 border-[#0a3a60] pb-4">
                <h1 class="font-serif text-3xl font-black text-[#072740] uppercase tracking-widest mb-1">Dhaka Global University</h1>
                <p class="text-xs text-gray-700 font-medium">Purbachal Model Town, Uttara, Dhaka, Bangladesh</p>
                <div class="mt-6 mb-2">
                    <span class="bg-[#0a3a60] text-white font-serif font-bold text-xl px-6 py-2 rounded-sm uppercase tracking-widest shadow-sm">
                        {{ strtoupper($certificate->title) }}
                    </span>
                </div>
            </div>

            <!-- Student Information Grid -->
            <div class="grid grid-cols-2 gap-x-12 gap-y-3 mb-8 text-xs text-gray-800">
                <div class="flex"><span class="w-40 font-bold">Student's Name</span> <span class="font-semibold">: {{ $certificate->student->name }}</span></div>
                <div class="flex"><span class="w-40 font-bold">Registration No - Session</span> <span>: {{ $certificate->reg_no ?: '48236683 - 2021-2022' }}</span></div>
                
                <div class="flex"><span class="w-40 font-bold">Father's Name</span> <span>: {{ $certificate->father_name ?: 'MOHAMMED BELAL' }}</span></div>
                <div class="flex"><span class="w-40 font-bold">Subject / Department</span> <span>: {{ $certificate->department ?: 'Computer Science and Engineering' }}</span></div>
                
                <div class="flex"><span class="w-40 font-bold">Mother's Name</span> <span>: {{ $certificate->mother_name ?: 'RAHENA AKTER' }}</span></div>
                <div class="flex"><span class="w-40 font-bold">Credit (Completed/Total)</span> <span>: {{ $certificate->credit_completed ?: '216/216' }}</span></div>
                
                <div class="flex"><span class="w-40 font-bold">Name of Course</span> <span>: {{ $certificate->course_name ?: 'Diploma Programme' }}</span></div>
                <div class="flex"><span class="w-40 font-bold">Exam. Roll</span> <span>: {{ $certificate->exam_roll ?: '46437' }}</span></div>
                
                <div class="col-span-2 mt-2 pt-2 border-t border-gray-200">
                    <span class="font-bold">Final Result: </span> <span class="font-bold text-sm">{{ $certificate->result ?: '3.96 Out Of 4.00' }}</span>
                </div>
            </div>

            <!-- Grades Table -->
            <table class="w-full text-xs border-collapse border border-gray-800 text-left mb-12 print-border">
                <thead>
                    <tr class="bg-gray-100 print-border">
                        <th class="border border-gray-800 px-3 py-2 text-center w-20">SEMESTER</th>
                        <th class="border border-gray-800 px-3 py-2 w-24">COURSE CODE</th>
                        <th class="border border-gray-800 px-3 py-2">COURSE TITLE</th>
                        <th class="border border-gray-800 px-3 py-2 text-center w-16">CREDIT</th>
                        <th class="border border-gray-800 px-3 py-2 text-center w-16">GRADE</th>
                        <th class="border border-gray-800 px-3 py-2 text-center w-16">GPA</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach($semestersData as $sem)
                        @php
                            $courses = $sem['courses'] ?? [];
                            $rowCount = count($courses);
                        @endphp
                        @foreach($courses as $index => $course)
                            <tr>
                                @if($index === 0)
                                    <td rowspan="{{ $rowCount }}" class="border border-gray-800 px-3 py-2 text-center font-bold font-serif uppercase">{{ $sem['name'] ?? 'SEMESTER' }}</td>
                                @endif
                                <td class="border border-gray-800 px-3 py-1">{{ $course['code'] ?? '-' }}</td>
                                <td class="border border-gray-800 px-3 py-1">{{ $course['title'] ?? '-' }}</td>
                                <td class="border border-gray-800 px-3 py-1 text-center">{{ $course['credit'] ?? '-' }}</td>
                                <td class="border border-gray-800 px-3 py-1 text-center">{{ $course['grade'] ?? '-' }}</td>
                                @if($index === 0)
                                    <td rowspan="{{ $rowCount }}" class="border border-gray-800 px-3 py-2 text-center font-bold">{{ $sem['gpa'] ?? '0.00' }}</td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

            <!-- Signatures & Footer -->
            <div class="mt-20 grid grid-cols-3 gap-8 text-center text-xs font-medium">
                <div>
                    <div class="border-t border-gray-800 pt-2 mx-6 print-border">Prepared by</div>
                </div>
                <div>
                    <div class="border-t border-gray-800 pt-2 mx-6 print-border">Compared by</div>
                </div>
                <div>
                    <div class="border-t border-gray-800 pt-2 mx-6 print-border">Controller of Examinations</div>
                </div>
            </div>

            <div class="mt-16 text-center text-[10px] text-gray-500 border-t border-gray-300 pt-4 print-border">
                <p>Address: Purbachal Model Town, Dhaka, Bangladesh</p>
                <p>E-mail: contact@dhakaglobal.university | Web: https://dhakaglobal.university</p>
            </div>
        </div>
    </div>
</x-dynamic-component>
