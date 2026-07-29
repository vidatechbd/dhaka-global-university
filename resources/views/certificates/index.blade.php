@php
    $layout = auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout';
    $isCreateAction = request()->query('action') === 'create';
@endphp

<x-dynamic-component :component="$layout">
    @if(auth()->user()->hasRole('Student'))
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Certificates') }}
            </h2>
        </x-slot>

        <div class="py-6 max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">{{ __('My Issued Certificates') }}</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Title') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Issued By') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @forelse($certificates as $certificate)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-semibold">{{ $certificate->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $certificate->creator->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $certificate->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                                        <a href="{{ route('certificates.show', $certificate) }}" class="text-blue-600 hover:text-blue-900 font-semibold">{{ __('View Certificate') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-400">{{ __('No certificates found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <!-- Admin / Teacher Full Width Certificate & Transcript Page -->
        <style>
            @media print {
                body * { visibility: hidden; }
                #sidebar, header, #form-section, .no-print, nav { display: none !important; }
                #certificate-section, #certificate-section * { visibility: visible; }
                #certificate-section {
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

        <div class="flex flex-col gap-6 w-full">
            @if(session('success'))
                <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-xs font-medium rounded-r-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-xs font-medium rounded-r-lg shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if($isCreateAction)
                <!-- Dynamic Academic Transcript & Certificate Creation Form -->
                <form id="certificate-form" method="POST" action="{{ route('certificates.store') }}" class="space-y-8">
                    @csrf
                    <input type="hidden" name="semesters" id="semesters-json" value="[]">

                    <!-- SECTION 1: Student Details Form -->
                    <section id="form-section" class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 no-print">
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('certificates.index') }}" class="text-gray-500 hover:text-gray-800">
                                    &larr; Back
                                </a>
                                <h2 class="text-xl font-bold text-[#072740] border-l-4 border-[#f7941d] pl-3">Generate Academic Transcript</h2>
                            </div>
                            <div class="flex items-center gap-3">
                                <button type="button" onclick="window.print()" class="bg-[#0a3a60] hover:bg-[#072740] text-white px-5 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 shadow-md shadow-[#0a3a60]/20 text-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Print / Save as PDF
                                </button>
                                <button type="submit" class="bg-[#00875a] hover:bg-[#006644] text-white px-5 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 shadow-md text-xs">
                                    ✓ Save to Database
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Select Student</label>
                                <select id="student_id" name="student_id" onchange="autoFillStudent(this)" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2.5 outline-none focus:border-[#0a3a60] text-xs" required>
                                    <option value="">-- Select Student --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" data-name="{{ $student->name }}" data-email="{{ $student->email }}">{{ $student->name }} ({{ $student->email }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Certificate Title</label>
                                <input type="text" name="title" value="Academic Transcript" oninput="updateTranscriptPreview()" id="input-title" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2.5 outline-none focus:border-[#0a3a60] text-xs font-semibold" required>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Department</label>
                                <input type="text" name="department" value="Computer Science and Engineering" oninput="updateTranscriptPreview()" id="input-dept" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2.5 outline-none focus:border-[#0a3a60] text-xs">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Student's Name</label>
                                <input type="text" id="input-student-name" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2.5 outline-none font-semibold text-[#072740] text-xs" readonly>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Father's Name</label>
                                <input type="text" name="father_name" value="MOHAMMED BELAL" oninput="updateTranscriptPreview()" id="input-father" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2.5 outline-none text-xs">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Mother's Name</label>
                                <input type="text" name="mother_name" value="RAHENA AKTER" oninput="updateTranscriptPreview()" id="input-mother" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2.5 outline-none text-xs">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Name of Course</label>
                                <input type="text" name="course_name" value="Diploma Programme" oninput="updateTranscriptPreview()" id="input-course" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2.5 outline-none text-xs">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Exam. Roll</label>
                                <input type="text" name="exam_roll" value="46437" oninput="updateTranscriptPreview()" id="input-roll" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2.5 outline-none text-xs">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Registration No - Session</label>
                                <input type="text" name="reg_no" value="48236683 - 2021-2022" oninput="updateTranscriptPreview()" id="input-reg" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2.5 outline-none text-xs">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Credit (Completed/Total)</label>
                                <input type="text" name="credit_completed" value="216/216" oninput="updateTranscriptPreview()" id="input-credit" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2.5 outline-none text-xs">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Final Result / CGPA</label>
                                <input type="text" name="result" value="3.96 Out Of 4.00" oninput="updateTranscriptPreview()" id="input-result" class="w-full bg-green-50 border border-green-200 text-green-700 font-bold rounded-lg px-4 py-2.5 outline-none text-xs">
                            </div>
                        </div>

                        <!-- Academic Semesters List (Summary) -->
                        <div class="mt-8">
                            <div class="flex justify-between items-center border-b pb-2 mb-4">
                                <h3 class="text-sm font-bold text-gray-700">Academic Semesters & Subjects Breakdown</h3>
                                <button type="button" onclick="openSemesterModal()" class="text-xs bg-[#0a3a60]/10 text-[#0a3a60] hover:bg-[#0a3a60] hover:text-white px-3 py-1.5 rounded-lg font-semibold transition-colors flex items-center gap-1 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Add Semester
                                </button>
                            </div>
                            <div id="semester-summary-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <!-- Dynamic Semester Summary Cards Injected Here -->
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 2: Printable Academic Transcript Preview (A4 exact design) -->
                    @php
                        $previewLogo   = ($setting->logo ?? null) ? asset($setting->logo) : null;
                        $previewName   = $setting->name    ?? 'Dhaka Global University';
                        $previewAddr   = $setting->address ?? 'Purbachal Model Town, Uttara, Dhaka, Bangladesh';
                        $previewEmail  = collect($setting->contacts ?? [])->firstWhere('type','Email')['value'] ?? 'contact@dhakaglobal.university';
                        $previewWeb    = collect($setting->social_medias ?? [])->firstWhere('platform','Website')['url']
                                        ?? collect($setting->social_medias ?? [])->first()['url']
                                        ?? 'https://dhakaglobal.university';
                    @endphp
                    <div id="certificate-section"
                         class="bg-white relative mx-auto overflow-hidden shadow-xl"
                         style="width:210mm; min-height:297mm; padding:10mm 15mm; font-family:'Times New Roman',Times,serif; box-sizing:border-box;">

                        {{-- Watermark --}}
                        <div class="absolute inset-0 z-0 flex justify-center items-center pointer-events-none" style="opacity:0.08;">
                            @if($previewLogo)
                                <img src="{{ $previewLogo }}" alt="Watermark" style="width:500px;height:auto;">
                            @else
                                <span style="font-size:120px;font-weight:900;color:#0a3a60;transform:rotate(-30deg);display:block;">🎓</span>
                            @endif
                        </div>

                        {{-- Document body --}}
                        <div class="relative z-10 text-black flex flex-col justify-between" style="min-height:277mm;">
                            <div>
                                {{-- University Header --}}
                                <div class="flex items-center justify-between mb-2">
                                    <div class="w-20">
                                        @if($previewLogo)
                                            <img src="{{ $previewLogo }}" alt="Logo" style="width:72px;height:auto;">
                                        @else
                                            <div style="width:72px;height:72px;display:flex;align-items:center;justify-content:center;background:#0a3a60;color:white;font-size:28px;border-radius:4px;">🎓</div>
                                        @endif
                                    </div>
                                    <div class="flex-1 text-center">
                                        <h1 class="text-[24px] font-bold leading-tight mb-0.5" style="font-family:'Times New Roman',Times,serif;">{{ $previewName }}</h1>
                                        <p class="text-[12px] font-bold leading-tight mb-0.5">{{ $previewAddr }}</p>
                                        <h2 class="text-[14px] font-bold underline underline-offset-2 mt-1">ACADEMIC TRANSCRIPT</h2>
                                    </div>
                                    <div class="w-20"></div>
                                </div>

                                {{-- Student Information --}}
                                <div class="mb-3 text-[12px] leading-[1.3] w-[85%]">
                                    <div class="flex mb-[1px]"><div class="w-48 font-bold">Student's Name</div><div class="w-4 font-bold">:</div><div id="preview-name" class="font-bold uppercase">MD SHAHEEN</div></div>
                                    <div class="flex mb-[1px]"><div class="w-48 font-bold">Father's Name</div><div class="w-4 font-bold">:</div><div id="preview-father" class="font-bold uppercase">MOHAMMED BELAL</div></div>
                                    <div class="flex mb-[1px]"><div class="w-48 font-bold">Mother's Name</div><div class="w-4 font-bold">:</div><div id="preview-mother" class="font-bold uppercase">RAHENA AKTER</div></div>
                                    <div class="flex mb-[1px]"><div class="w-48 font-bold">Name of Course</div><div class="w-4 font-bold">:</div><div id="preview-course" class="font-bold">Diploma Programme</div></div>
                                    <div class="flex mb-[1px]"><div class="w-48 font-bold">Exam. Roll</div><div class="w-4 font-bold">:</div><div id="preview-roll" class="font-bold">46437</div></div>
                                    <div class="flex mb-[1px]"><div class="w-48 font-bold">Registration No - Session</div><div class="w-4 font-bold">:</div><div id="preview-reg" class="font-bold">48236683 - 2021-2022</div></div>
                                    <div class="flex mb-[1px]"><div class="w-48 font-bold">Subject/Department Name</div><div class="w-4 font-bold">:</div><div id="preview-dept" class="font-bold">Computer Science and Engineering</div></div>
                                    <div class="flex mb-[1px]"><div class="w-48 font-bold">Credit (Completed/Total)</div><div class="w-4 font-bold">:</div><div id="preview-credit" class="font-bold">216/216</div></div>
                                    <div class="flex mb-[1px]"><div class="w-48 font-bold">Result</div><div class="w-4 font-bold">:</div><div id="preview-result" class="font-bold">3.96 Out Of 4.00</div></div>
                                </div>

                                {{-- Grades Table --}}
                                <table class="w-full border-collapse border border-black text-[10px] mb-3 print-border" style="line-height:1.15;">
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
                                    <tbody id="transcript-table-body">
                                        <!-- Dynamic Rows Generated via JavaScript -->
                                    </tbody>
                                </table>
                            </div>

                            {{-- Signatures & Footer --}}
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
                                    Address: {{ $previewAddr }}<br>
                                    E-mail: {{ $previewEmail }}, Web: {{ $previewWeb }}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Add Semester Modal -->
                <div id="semester-modal" class="hidden fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity duration-300 opacity-0 no-print">
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col overflow-hidden transform scale-95 transition-transform duration-300" id="semester-modal-content">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 shrink-0">
                            <h3 class="text-lg font-bold text-[#072740] flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#f7941d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Add New Semester
                            </h3>
                            <button type="button" onclick="closeSemesterModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-md hover:bg-gray-200 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <div class="p-6 overflow-y-auto flex-1 bg-white">
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Semester Name (e.g. 1ST)</label>
                                    <input type="text" id="sem-name-input" placeholder="1ST" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-3 py-2 outline-none focus:border-[#0a3a60] font-serif uppercase text-xs">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Semester GPA</label>
                                    <input type="number" step="0.01" id="sem-gpa-input" placeholder="4.00" class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-3 py-2 outline-none focus:border-[#0a3a60] text-xs">
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-4">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="text-xs font-bold text-gray-700">Courses / Subjects</h4>
                                    <button type="button" onclick="addCourseRow()" class="text-xs text-[#0a3a60] hover:text-[#072740] font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Add Course Row
                                    </button>
                                </div>
                                
                                <div id="course-rows-container" class="space-y-2">
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 shrink-0">
                            <button type="button" onclick="closeSemesterModal()" class="px-4 py-2 rounded-lg text-xs font-medium text-gray-600 hover:bg-gray-200 transition-colors">Cancel</button>
                            <button type="button" onclick="saveSemester()" class="px-5 py-2 rounded-lg text-xs font-medium text-white bg-[#0a3a60] hover:bg-[#072740] transition-colors shadow-md flex items-center gap-2">
                                Save to Transcript
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    let stateSemesters = [
                        {
                            name: '1ST',
                            gpa: '4.00',
                            courses: [
                                { code: '21011', title: 'Engineering Drawing', credit: '2', grade: 'A+' },
                                { code: '25911', title: 'Mathematics-I', credit: '4', grade: 'A+' },
                                { code: '21711', title: 'Bangla-1', credit: '3', grade: 'A+' },
                                { code: '21712', title: 'English-1', credit: '3', grade: 'A+' },
                                { code: '25912', title: 'Physics-I', credit: '4', grade: 'A+' },
                                { code: '28511', title: 'Computer Office Application', credit: '3', grade: 'A+' }
                            ]
                        },
                        {
                            name: '2ND',
                            gpa: '3.90',
                            courses: [
                                { code: '26711', title: 'Basic Electricity', credit: '4', grade: 'A' },
                                { code: '21012', title: 'Engineering Drawing-II', credit: '2', grade: 'A+' },
                                { code: '21722', title: 'English-II', credit: '3', grade: 'A+' },
                                { code: '25812', title: 'Physical Education & Life Skills Development', credit: '2', grade: 'A' }
                            ]
                        }
                    ];

                    document.addEventListener('DOMContentLoaded', () => {
                        addCourseRow();
                        renderSemesters();
                        updateTranscriptPreview();
                    });

                    function autoFillStudent(selectEl) {
                        const option = selectEl.options[selectEl.selectedIndex];
                        const name = option.getAttribute('data-name') || '';
                        document.getElementById('input-student-name').value = name;
                        updateTranscriptPreview();
                    }

                    function updateTranscriptPreview() {
                        document.getElementById('preview-name').textContent = (document.getElementById('input-student-name').value || '').toUpperCase();
                        document.getElementById('preview-father').textContent = (document.getElementById('input-father').value || '').toUpperCase();
                        document.getElementById('preview-mother').textContent = (document.getElementById('input-mother').value || '').toUpperCase();
                        document.getElementById('preview-course').textContent = document.getElementById('input-course').value || '';
                        document.getElementById('preview-roll').textContent = document.getElementById('input-roll').value || '';
                        document.getElementById('preview-reg').textContent = document.getElementById('input-reg').value || '';
                        document.getElementById('preview-dept').textContent = document.getElementById('input-dept').value || '';
                        document.getElementById('preview-credit').textContent = document.getElementById('input-credit').value || '';
                        document.getElementById('preview-result').textContent = document.getElementById('input-result').value || '';
                    }

                    function renderSemesters() {
                        document.getElementById('semesters-json').value = JSON.stringify(stateSemesters);

                        // 1. Render Summary Grid
                        const grid = document.getElementById('semester-summary-grid');
                        grid.innerHTML = '';

                        stateSemesters.forEach((sem, semIdx) => {
                            const liHTML = sem.courses.map(c => `<li>${c.code} - ${c.title}</li>`).join('');
                            const cardHTML = `
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 relative group">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-semibold text-[#072740] text-xs">${sem.name} Semester (GPA: ${sem.gpa})</h4>
                                        <button type="button" onclick="removeSemester(${semIdx})" class="text-red-400 hover:text-red-600 transition-opacity no-print" title="Remove">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                    <ul class="text-[11px] text-gray-600 space-y-1">
                                        ${liHTML}
                                    </ul>
                                </div>
                            `;
                            grid.insertAdjacentHTML('beforeend', cardHTML);
                        });

                        // 2. Render Transcript Table Body
                        const tbody = document.getElementById('transcript-table-body');
                        tbody.innerHTML = '';

                        stateSemesters.forEach((sem) => {
                            const rowCount = sem.courses.length;
                            sem.courses.forEach((course, index) => {
                                let trHTML = '';
                                if (index === 0) {
                                    trHTML = `
                                        <tr>
                                            <td rowspan="${rowCount}" class="border border-black text-center font-bold align-middle" style="padding:1.5px 4px;">${sem.name}</td>
                                            <td class="border border-black text-center" style="padding:1.5px 4px;">${course.code}</td>
                                            <td class="border border-black" style="padding:1.5px 8px;">${course.title}</td>
                                            <td class="border border-black text-center" style="padding:1.5px 4px;">${course.credit}</td>
                                            <td class="border border-black text-center font-bold" style="padding:1.5px 4px;">${course.grade}</td>
                                            <td rowspan="${rowCount}" class="border border-black text-center font-bold align-middle" style="padding:1.5px 4px;">${sem.gpa}</td>
                                        </tr>
                                    `;
                                } else {
                                    trHTML = `
                                        <tr>
                                            <td class="border border-black text-center" style="padding:1.5px 4px;">${course.code}</td>
                                            <td class="border border-black" style="padding:1.5px 8px;">${course.title}</td>
                                            <td class="border border-black text-center" style="padding:1.5px 4px;">${course.credit}</td>
                                            <td class="border border-black text-center font-bold" style="padding:1.5px 4px;">${course.grade}</td>
                                        </tr>
                                    `;
                                }
                                tbody.insertAdjacentHTML('beforeend', trHTML);
                            });
                        });

                    }

                    function removeSemester(index) {
                        if (confirm('Are you sure you want to remove this semester?')) {
                            stateSemesters.splice(index, 1);
                            renderSemesters();
                        }
                    }

                    function openSemesterModal() {
                        const modal = document.getElementById('semester-modal');
                        const content = document.getElementById('semester-modal-content');
                        modal.classList.remove('hidden');
                        setTimeout(() => {
                            modal.classList.remove('opacity-0');
                            content.classList.remove('scale-95');
                            content.classList.add('scale-100');
                        }, 10);
                    }

                    function closeSemesterModal() {
                        const modal = document.getElementById('semester-modal');
                        const content = document.getElementById('semester-modal-content');
                        modal.classList.add('opacity-0');
                        content.classList.remove('scale-100');
                        content.classList.add('scale-95');
                        setTimeout(() => {
                            modal.classList.add('hidden');
                        }, 300);
                    }

                    function addCourseRow() {
                        const container = document.getElementById('course-rows-container');
                        const rowId = Date.now() + Math.random();
                        const rowHTML = `
                            <div class="grid grid-cols-12 gap-2 items-end bg-gray-50 p-2 rounded border border-gray-200 course-input-row" id="course-${rowId}">
                                <div class="col-span-3">
                                    <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-0.5">Code</label>
                                    <input type="text" class="course-code w-full bg-white border border-gray-200 rounded px-2 py-1 text-xs outline-none focus:border-[#0a3a60]" placeholder="e.g. 28591">
                                </div>
                                <div class="col-span-5">
                                    <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-0.5">Title</label>
                                    <input type="text" class="course-title w-full bg-white border border-gray-200 rounded px-2 py-1 text-xs outline-none focus:border-[#0a3a60]" placeholder="Course Title">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-0.5">Cr.</label>
                                    <input type="number" class="course-credit w-full bg-white border border-gray-200 rounded px-2 py-1 text-xs outline-none focus:border-[#0a3a60]" placeholder="4">
                                </div>
                                <div class="col-span-2 flex gap-1 items-end">
                                    <div class="flex-1">
                                        <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-0.5">Grade</label>
                                        <select class="course-grade w-full bg-white border border-gray-200 rounded px-1 py-1 text-xs outline-none focus:border-[#0a3a60]">
                                            <option value="A+">A+</option>
                                            <option value="A">A</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="F">F</option>
                                        </select>
                                    </div>
                                    <button type="button" onclick="document.getElementById('course-${rowId}').remove()" class="p-1.5 text-red-400 hover:bg-red-50 hover:text-red-600 rounded transition-colors" title="Remove">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML('beforeend', rowHTML);
                    }

                    function saveSemester() {
                        const semName = document.getElementById('sem-name-input').value.toUpperCase().trim() || 'N/A';
                        const semGPA = parseFloat(document.getElementById('sem-gpa-input').value || 0).toFixed(2);
                        
                        const courseRows = document.querySelectorAll('.course-input-row');
                        if (courseRows.length === 0) {
                            alert('Please add at least one course.');
                            return;
                        }
                        
                        let coursesData = [];
                        courseRows.forEach(row => {
                            coursesData.push({
                                code: row.querySelector('.course-code').value || '-',
                                title: row.querySelector('.course-title').value || '-',
                                credit: row.querySelector('.course-credit').value || '-',
                                grade: row.querySelector('.course-grade').value
                            });
                        });

                        stateSemesters.push({
                            name: semName,
                            gpa: semGPA,
                            courses: coursesData
                        });

                        renderSemesters();

                        document.getElementById('sem-name-input').value = '';
                        document.getElementById('sem-gpa-input').value = '';
                        document.getElementById('course-rows-container').innerHTML = '';
                        addCourseRow();
                        closeSemesterModal();
                    }
                </script>
            @else
                <!-- Generated Certificates List Table (Full Width) -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm w-full">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <h2 class="text-xl font-bold text-[#072740]">{{ __('All Generated Certificates') }}</h2>
                        
                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ route('certificates.index') }}?action=create" class="px-4 py-2 bg-[#0a3a60] hover:bg-[#072740] text-white font-bold text-xs rounded-lg shadow transition">
                                + Generate Certificate
                            </a>
                            <button type="button" class="px-4 py-1.5 bg-[#00875a] text-white font-bold text-[11px] rounded-md shadow-sm">CSV</button>
                            <button type="button" class="px-4 py-1.5 bg-[#d81b60] text-white font-bold text-[11px] rounded-md shadow-sm">Excel</button>
                            <button type="button" class="px-4 py-1.5 bg-[#f7941d] text-white font-bold text-[11px] rounded-md shadow-sm">PDF</button>
                            <button type="button" onclick="window.print()" class="px-4 py-1.5 bg-[#0070c0] text-white font-bold text-[11px] rounded-md shadow-sm">Print</button>
                        </div>
                    </div>

                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-gray-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                                    <th class="px-6 py-4 text-center">#</th>
                                    <th class="px-6 py-4">Student Name</th>
                                    <th class="px-6 py-4">Title</th>
                                    <th class="px-6 py-4">Department</th>
                                    <th class="px-6 py-4 text-center">Exam Roll</th>
                                    <th class="px-6 py-4 text-center">Result</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs text-slate-700">
                                @forelse($certificates as $index => $certificate)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-6 py-4 text-center text-slate-500 font-medium">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-bold text-slate-900">{{ $certificate->student->name }}</td>
                                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $certificate->title }}</td>
                                        <td class="px-6 py-4 font-medium text-slate-600">{{ $certificate->department ?: 'CSE' }}</td>
                                        <td class="px-6 py-4 text-center font-mono">{{ $certificate->exam_roll ?: (46437 + $index) }}</td>
                                        <td class="px-6 py-4 text-center font-bold text-slate-900">{{ $certificate->result ?: '3.96' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-block px-2.5 py-1 bg-green-50 border border-green-200 text-green-700 font-bold text-[10px] rounded-md tracking-wider">
                                                GENERATED
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right whitespace-nowrap space-x-2">
                                            <a href="{{ route('certificates.show', $certificate) }}" class="inline-flex items-center justify-center p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-md transition shadow-sm" title="View Transcript">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-8 text-center text-gray-400 font-medium">
                                            {{ __('No certificates generated yet.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    @endif
</x-dynamic-component>
