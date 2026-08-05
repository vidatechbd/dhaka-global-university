@php
    $layout = auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout';
@endphp

<x-dynamic-component :component="$layout">
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
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-xs font-semibold rounded-r-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 text-xs font-semibold rounded-r-lg shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Dynamic Academic Transcript & Certificate Creation Form -->
        <form id="marksheet-form" method="POST" action="{{ route('marksheets.store') }}" class="space-y-8">
            @csrf
            <input type="hidden" name="semesters" id="semesters-json" value="[]">

            <!-- SECTION 1: Student Details Form -->
            <section id="form-section" class="bg-white border border-slate-200 p-8 rounded-3xl shadow-sm no-print">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('marksheets.index') }}" class="text-slate-500 hover:text-slate-800 transition font-bold text-sm inline-flex items-center gap-1">
                            <i class="ph-bold ph-arrow-left"></i>
                            Back
                        </a>
                        <h2 class="text-xl font-bold text-primary border-l-4 border-secondary pl-3">Generate Academic Transcript</h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="window.print()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2 rounded-lg font-bold transition flex items-center gap-2 shadow-sm text-xs border border-slate-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print / Save as PDF
                        </button>
                        <button type="submit" class="bg-primary hover:bg-primaryDark text-white px-5 py-2 rounded-lg font-bold transition flex items-center gap-2 shadow-md shadow-primary/20 text-xs">
                            <i class="ph-bold ph-check text-sm"></i>
                            Save to Database
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Select Student</label>
                        <select id="student_id" name="student_id" onchange="autoFillStudent(this)" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-4 py-2.5 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs font-semibold">
                            <option value="" class="bg-white">-- Select Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" data-name="{{ $student->name }}" data-email="{{ $student->email }}" class="bg-white">{{ $student->name }} ({{ $student->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Certificate Title</label>
                        <input type="text" name="title" value="Academic Transcript" oninput="updateTranscriptPreview()" id="input-title" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-4 py-2.5 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs font-bold" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Student's Name</label>
                        <input type="text" name="student_name" id="input-student-name" value="{{ old('student_name') }}" oninput="updateTranscriptPreview()" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-4 py-2.5 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs font-bold" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Father's Name</label>
                        <input type="text" name="father_name" value="MOHAMMED BELAL" oninput="updateTranscriptPreview()" id="input-father" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-4 py-2.5 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs font-semibold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Mother's Name</label>
                        <input type="text" name="mother_name" value="RAHENA AKTER" oninput="updateTranscriptPreview()" id="input-mother" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-4 py-2.5 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs font-semibold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Name of Course</label>
                        <input type="text" name="course_name" value="Diploma Programme" oninput="updateTranscriptPreview()" id="input-course" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-4 py-2.5 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs font-semibold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Exam. Roll</label>
                        <input type="number" name="exam_roll" value="" oninput="updateTranscriptPreview()" id="input-roll" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-4 py-2.5 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs font-semibold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Registration No</label>
                        <input type="text" name="reg_no" value="" oninput="updateTranscriptPreview()" id="input-reg" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-4 py-2.5 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs font-semibold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Session</label>
                        <input type="text" name="session" value="" oninput="updateTranscriptPreview()" id="input-session" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-4 py-2.5 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs font-semibold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Subject/Department Name</label>
                        <input type="text" name="department" value="" oninput="updateTranscriptPreview()" id="input-dept" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-4 py-2.5 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs font-semibold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Credit (Completed/Total)</label>
                        <input type="text" name="credit_completed" value="" oninput="updateTranscriptPreview()" id="input-credit" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-4 py-2.5 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs font-semibold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-1">Final Result / CGPA</label>
                        <input type="text" name="result" placeholder="3.96 Out Of 4.00" value="" oninput="updateTranscriptPreview()" id="input-result" class="w-full bg-white border border-slate-300 text-[#d97d10] rounded-lg px-4 py-2.5 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs font-bold">
                    </div>
                </div>

                <!-- Academic Years List (Summary) -->
                <div class="mt-8">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-2 mb-4">
                        <h3 class="text-sm font-bold text-slate-800">Academic Years & Subjects Breakdown</h3>
                        <button type="button" onclick="openSemesterModal()" class="text-xs bg-[#e0edf7] text-primary hover:bg-[#d0e2f2] px-3 py-1.5 rounded-lg font-bold transition-colors flex items-center gap-1 shadow-sm border border-[#0a3a60]/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Year
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
                $previewPreparedBy = ($setting->marksheet_prepared_by ?? null) ? asset($setting->marksheet_prepared_by) : null;
                $previewComparedBy = ($setting->marksheet_compared_by ?? null) ? asset($setting->marksheet_compared_by) : null;
                $previewController = ($setting->marksheet_controller_signature ?? null) ? asset($setting->marksheet_controller_signature) : null;
            @endphp
            <div id="certificate-section"
                 class="bg-white relative mx-auto overflow-hidden shadow-2xl"
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
                            <div class="flex mb-[1px]"><div class="w-48 font-bold">Registration No</div><div class="w-4 font-bold">:</div><div id="preview-reg" class="font-bold">48236683</div></div>
                            <div class="flex mb-[1px]"><div class="w-48 font-bold">Session</div><div class="w-4 font-bold">:</div><div id="preview-session" class="font-bold">2021-2022</div></div>
                            <div class="flex mb-[1px]"><div class="w-48 font-bold">Subject/Department Name</div><div class="w-4 font-bold">:</div><div id="preview-dept" class="font-bold">Computer Science and Engineering</div></div>
                            <div class="flex mb-[1px]"><div class="w-48 font-bold">Credit (Completed/Total)</div><div class="w-4 font-bold">:</div><div id="preview-credit" class="font-bold">216/216</div></div>
                            <div class="flex mb-[1px]"><div class="w-48 font-bold">Result</div><div class="w-4 font-bold">:</div><div id="preview-result" class="font-bold">3.96 Out Of 4.00</div></div>
                        </div>

                        {{-- Grades Table --}}
                        <table class="w-full border-collapse border border-black text-[10px] mb-3 print-border" style="line-height:1.15;">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="border border-black py-1 px-1 font-bold text-center w-14">YEAR</th>
                                    <th class="border border-black py-1 px-1 font-bold text-center w-20">COURSE CODE</th>
                                    <th class="border border-black py-1 px-2 font-bold text-left">COURSE TITLE</th>
                                    <th class="border border-black py-1 px-1 font-bold text-center w-14">CREDIT</th>
                                    <th class="border border-black py-1 px-1 font-bold text-center w-14">GRADE</th>
                                    <th class="border border-black py-1 px-1 font-bold text-center w-16">YEAR CGP</th>
                                </tr>
                            </thead>
                            <tbody id="transcript-table-body">
                                <!-- Dynamic Rows Generated via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    {{-- Signatures & Footer --}}
                    <div>
                        <div class="flex justify-between items-end mt-6">
                            <!-- Left: QR Code -->
                            <div class="flex flex-col items-center">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://dhakaglobal.university" alt="QR Code" class="w-16 h-16 border border-gray-300 p-1 bg-white">
                                <p class="text-[7px] font-bold mt-1 text-gray-500 text-center">SCAN TO VERIFY</p>
                            </div>
                            
                            <!-- Signature: Prepared by -->
                            <div class="text-center w-36 flex flex-col items-center">
                                <div class="h-8 w-28 flex items-end justify-center mb-1">
                                    @if($previewPreparedBy)
                                        <img src="{{ $previewPreparedBy }}" alt="Prepared By" class="max-h-full max-w-full object-contain">
                                    @endif
                                </div>
                                <div class="border-t border-black font-bold pt-1 text-[12px] italic w-full">Prepared by</div>
                            </div>
                            
                            <!-- Signature: Compared by -->
                            <div class="text-center w-36 flex flex-col items-center">
                                <div class="h-8 w-28 flex items-end justify-center mb-1">
                                    @if($previewComparedBy)
                                        <img src="{{ $previewComparedBy }}" alt="Compared By" class="max-h-full max-w-full object-contain">
                                    @endif
                                </div>
                                <div class="border-t border-black font-bold pt-1 text-[12px] italic w-full">Compared by</div>
                            </div>
                            
                            <!-- Signature: Controller of Examinations -->
                            <div class="text-center w-44 flex flex-col items-center">
                                <div class="h-8 w-36 flex items-end justify-center mb-1">
                                    @if($previewController)
                                        <img src="{{ $previewController }}" alt="Controller Signature" class="max-h-full max-w-full object-contain">
                                    @endif
                                </div>
                                <div class="border-t border-black font-bold pt-1 text-[12px] italic w-full">Controller of Examinations</div>
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
        <div id="semester-modal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity duration-300 opacity-0 no-print">
            <div class="bg-white border border-slate-200 rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col overflow-hidden transform scale-95 transition-transform duration-300" id="semester-modal-content">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50 shrink-0">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Add New Year
                    </h3>
                    <button type="button" onclick="closeSemesterModal()" class="text-slate-400 hover:text-slate-700 p-1 rounded-md hover:bg-slate-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6 overflow-y-auto flex-1 bg-white text-slate-800">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Year (e.g. 1ST YEAR)</label>
                            <input type="text" id="sem-name-input" placeholder="1ST YEAR" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-3 py-2 outline-none focus:border-primary focus:ring-1 focus:ring-primary font-serif uppercase text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Year CGP</label>
                            <input type="number" step="0.01" id="sem-gpa-input" placeholder="4.00" class="w-full bg-white border border-slate-300 text-slate-800 rounded-lg px-3 py-2 outline-none focus:border-primary focus:ring-1 focus:ring-primary text-xs">
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-4">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-xs font-bold text-slate-800">Courses / Subjects</h4>
                            <button type="button" onclick="addCourseRow()" class="text-xs text-primary hover:text-primaryDark font-bold flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Add Course Row
                            </button>
                        </div>
                        
                        <div id="course-rows-container" class="space-y-2">
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3 shrink-0">
                    <button type="button" onclick="closeSemesterModal()" class="px-4 py-2 rounded-lg text-xs font-bold text-slate-500 hover:bg-slate-100 transition">Cancel</button>
                    <button type="button" onclick="saveSemester()" class="px-5 py-2 rounded-lg text-xs font-bold text-white bg-primary hover:bg-primaryDark transition-colors shadow-md shadow-primary/20 flex items-center gap-2">
                        Save to Transcript
                    </button>
                </div>
            </div>
        </div>

        <script>
            let stateSemesters = [
                {
                    year: '1ST YEAR',
                    year_cgp: '4.00',
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
                    year: '2ND YEAR',
                    year_cgp: '3.90',
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
                document.getElementById('preview-session').textContent = document.getElementById('input-session').value || '';
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
                        <div class="bg-slate-50/60 border border-slate-200 rounded-2xl p-4 relative group text-slate-800">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-primary text-xs">${sem.year} (CGP: ${sem.year_cgp})</h4>
                                <button type="button" onclick="removeSemester(${semIdx})" class="text-rose-500 hover:text-rose-600 transition no-print" title="Remove">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                            <ul class="text-[11px] text-slate-500 space-y-1">
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
                                    <td rowspan="${rowCount}" class="border border-black text-center font-bold align-middle" style="padding:1.5px 4px;">${sem.year}</td>
                                    <td class="border border-black text-center" style="padding:1.5px 4px;">${course.code}</td>
                                    <td class="border border-black" style="padding:1.5px 8px;">${course.title}</td>
                                    <td class="border border-black text-center" style="padding:1.5px 4px;">${course.credit}</td>
                                    <td class="border border-black text-center font-bold" style="padding:1.5px 4px;">${course.grade}</td>
                                    <td rowspan="${rowCount}" class="border border-black text-center font-bold align-middle" style="padding:1.5px 4px;">${sem.year_cgp}</td>
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
                if (confirm('Are you sure you want to remove this year?')) {
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

            // Courses management in modal
            function addCourseRow() {
                const container = document.getElementById('course-rows-container');
                const rowId = Date.now() + Math.random();
                const rowHTML = `
                    <div class="grid grid-cols-12 gap-2 items-end bg-slate-50 p-2 rounded border border-slate-200 course-input-row" id="course-${rowId}">
                        <div class="col-span-3">
                            <label class="block text-[10px] font-bold text-slate-600 uppercase mb-0.5">Code</label>
                            <input type="text" class="course-code w-full bg-white border border-slate-300 rounded px-2 py-1 text-xs text-slate-800 outline-none focus:border-primary font-semibold" placeholder="e.g. 28591">
                        </div>
                        <div class="col-span-5">
                            <label class="block text-[10px] font-bold text-slate-600 uppercase mb-0.5">Title</label>
                            <input type="text" class="course-title w-full bg-white border border-slate-300 rounded px-2 py-1 text-xs text-slate-800 outline-none focus:border-primary font-semibold" placeholder="Course Title">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-bold text-slate-600 uppercase mb-0.5">Cr.</label>
                            <input type="number" class="course-credit w-full bg-white border border-slate-300 rounded px-2 py-1 text-xs text-slate-800 outline-none focus:border-primary font-semibold" placeholder="4">
                        </div>
                        <div class="col-span-2 flex gap-1 items-end">
                            <div class="flex-1">
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-0.5">Grade</label>
                                <select class="course-grade w-full bg-white border border-slate-300 rounded px-1 py-1 text-xs text-slate-800 outline-none focus:border-primary font-semibold">
                                    <option value="A+" class="bg-white">A+</option>
                                    <option value="A" class="bg-white">A</option>
                                    <option value="A-" class="bg-white">A-</option>
                                    <option value="B+" class="bg-white">B+</option>
                                    <option value="B" class="bg-white">B</option>
                                    <option value="B-" class="bg-white">B-</option>
                                    <option value="C+" class="bg-white">C+</option>
                                    <option value="C" class="bg-white">C</option>
                                    <option value="D" class="bg-white">D</option>
                                    <option value="F" class="bg-white">F</option>
                                </select>
                            </div>
                            <button type="button" onclick="document.getElementById('course-${rowId}').remove()" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded transition-colors" title="Remove">
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
                    year: semName,
                    year_cgp: semGPA,
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
    </div>
</x-dynamic-component>
