@php
    $layout = auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout';
    $previewLogo   = ($setting->logo ?? null) ? asset($setting->logo) : null;
    $previewName   = $setting->name    ?? 'Bayt al-Hikmah Global University';
    $previewAddr   = $setting->address ?? 'Purbachal Model Town, Dhaka, Bangladesh';
@endphp

<x-dynamic-component :component="$layout">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&family=Cinzel:wght@600;700;800;900&display=swap" rel="stylesheet">

    <style>
        .certificate-preview-box {
            background-color: #fbf8eb;
            width: 11.69in;
            height: 8.27in;
            padding: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            box-sizing: border-box;
        }

        .certificate-content-border {
            border: 1.5px solid #222;
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-sizing: border-box;
        }

        .repeating-university-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            color: rgba(180, 160, 110, 0.15);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8.5px;
            font-weight: bold;
            line-height: 1.5;
            text-align: justify;
            overflow: hidden;
            pointer-events: none;
            padding: 8px;
            box-sizing: border-box;
        }

        .watermark-seal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px;
            height: 320px;
            border-radius: 50%;
            border: 4px solid rgba(180, 160, 110, 0.3);
            z-index: 2;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(251, 248, 235, 0.65); 
        }

        .watermark-seal::before {
            content: '';
            position: absolute;
            width: 290px;
            height: 290px;
            border-radius: 50%;
            border: 1px solid rgba(180, 160, 110, 0.15);
        }

        .watermark-seal::after {
            content: 'SEAL';
            font-family: 'Cinzel', serif;
            font-size: 55px;
            color: rgba(180, 160, 110, 0.08);
            font-weight: bold;
            letter-spacing: 10px;
        }

        .text-university-name {
            font-family: 'Arial Black', 'Arial Bold', Arial, sans-serif;
            font-weight: 900;
            color: #000;
            letter-spacing: -0.5px;
            transform: scaleY(1.05); 
            display: inline-block;
        }

        .text-old-english {
            font-family: 'UnifrakturMaguntia', serif;
            font-weight: normal;
            color: #000;
        }

        .text-engravers {
            font-family: 'Copperplate', 'Copperplate Gothic Bold', 'Copperplate Gothic Light', 'Cinzel', serif;
            font-weight: 800;
            color: #111;
            letter-spacing: 0.08em;
            word-spacing: 0.25em;
        }

        .text-sans-small {
            font-family: Arial, Helvetica, sans-serif;
        }

        .fill-in-line {
            display: inline-block;
            border-bottom: 2px solid #000;
            padding: 0 6px;
            font-weight: 900;
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
            padding: 30px 45px 15px 45px;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-sizing: border-box;
            justify-content: space-between;
        }
    </style>

    <div class="flex flex-col gap-6 w-full">
        <form id="certificate-form" method="POST" action="{{ route('certificates.store') }}" class="space-y-8">
            @csrf

            <!-- SECTION 1: Inputs -->
            <section id="form-section" class="bg-bgclr-200 border border-bgclr-300 p-8 rounded-3xl shadow-sm no-print">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6 pb-4 border-b border-bgclr-300">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('certificates.index') }}" class="text-textclr-200 hover:text-textclr-100 transition font-bold text-sm">
                            &larr; Back
                        </a>
                        <h2 class="text-xl font-bold text-textclr-100 border-l-4 border-primary-300 pl-3">Generate Student Certificate</h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="submit" class="bg-primary-300 hover:bg-primary-300/90 text-white px-5 py-2 rounded-lg font-bold transition flex items-center gap-2 shadow-sm text-xs">
                            ✓ Save Certificate
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-textclr-200 uppercase tracking-wide mb-1">Select Student (Optional)</label>
                        <select id="student_select" onchange="autoFillStudent(this)" class="w-full bg-bgclr-100 border border-bgclr-300 text-textclr-100 rounded-lg px-4 py-2.5 outline-none focus:border-primary-300 text-xs font-semibold">
                            <option value="">-- Custom (No Student Record) --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" data-name="{{ $student->name }}" class="bg-bgclr-100">{{ $student->name }} ({{ $student->email }})</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="student_id" id="student_id" value="">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-textclr-200 uppercase tracking-wide mb-1">Student's Name</label>
                        <input type="text" name="name" id="input-name" oninput="updatePreview()" value="Jack Nicholson" class="w-full bg-bgclr-100 border border-bgclr-300 text-textclr-100 rounded-lg px-4 py-2.5 outline-none focus:border-primary-300 text-xs font-bold" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-textclr-200 uppercase tracking-wide mb-1">Exam. Roll</label>
                        <input type="text" name="roll" id="input-roll" oninput="updatePreview()" value="46437" class="w-full bg-bgclr-100 border border-bgclr-300 text-textclr-100 rounded-lg px-4 py-2.5 outline-none focus:border-primary-300 text-xs font-semibold" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-textclr-200 uppercase tracking-wide mb-1">Subject/Degree</label>
                        <input type="text" name="subject" id="input-subject" oninput="updatePreview()" value="Diploma in Computer Science and Engineering" class="w-full bg-bgclr-100 border border-bgclr-300 text-textclr-100 rounded-lg px-4 py-2.5 outline-none focus:border-primary-300 text-xs font-semibold" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-textclr-200 uppercase tracking-wide mb-1">CGPA</label>
                        <input type="text" name="cgpa" id="input-cgpa" oninput="updatePreview()" value="3.96" class="w-full bg-bgclr-100 border border-bgclr-300 text-textclr-100 rounded-lg px-4 py-2.5 outline-none focus:border-primary-300 text-xs font-semibold" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-textclr-200 uppercase tracking-wide mb-1">Out of Scale</label>
                        <input type="text" name="out_of" id="input-outof" oninput="updatePreview()" value="4.00" class="w-full bg-bgclr-100 border border-bgclr-300 text-textclr-100 rounded-lg px-4 py-2.5 outline-none focus:border-primary-300 text-xs font-semibold" required>
                    </div>
                </div>
            </section>

            <!-- SECTION 2: Preview Panel -->
            <div class="w-full overflow-x-auto py-6 flex justify-center">
                <div class="certificate-preview-box">
                    <div class="certificate-content-border">
                        <div class="repeating-university-bg" id="bg-text"></div>
                        <div class="watermark-seal"></div>

                        <div class="content-wrapper">
                            <!-- Main University Name -->
                            <header class="text-center mt-2 mb-6">
                                <h1 class="text-university-name text-[32px] sm:text-[40px] md:text-[46px] m-0 leading-none uppercase">
                                    {{ $previewName }}
                                </h1>
                            </header>

                            <!-- Certification Text -->
                            <div class="text-center mb-4">
                                <p class="text-old-english text-[20px] md:text-[24px] m-0 tracking-wider">
                                    This is to certify that
                                </p>
                            </div>

                            <!-- Student Name -->
                            <div class="text-center mb-6">
                                <h2 id="preview-name" class="text-engravers text-[26px] md:text-[36px] m-0 uppercase font-black">
                                    Jack Nicholson
                                </h2>
                            </div>

                            <!-- Certificate Body Text -->
                            <div class="text-justify px-6 md:px-14 mb-auto">
                                <p class="text-engravers text-[14px] md:text-[18px] leading-[2.3] m-0 uppercase">
                                    HAS FULFILLED ALL REQUIREMENTS FOR THE DEGREE 
                                    OF <span id="preview-subject">DIPLOMA IN COMPUTER SCIENCE AND ENGINEERING</span>. BEARING ROLL NO IS <span class="fill-in-line" id="preview-roll">46437</span> . HE SECURED 
                                    CGPA <span class="fill-in-line" id="preview-cgpa">3.96</span> IN ON SCALE OF <span class="fill-in-line" id="preview-outof">4.00</span> .
                                </p>
                            </div>

                            <!-- Footer Section -->
                            <div class="mt-4 flex flex-col justify-end">
                                
                                <!-- Middle Footer row -->
                                <div class="flex justify-between items-end px-4 md:px-12 mb-3">
                                    
                                    <!-- Left: QR Code -->
                                    <div class="w-20 h-20 bg-white border border-black p-1">
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-[9px] font-bold text-center">QR CODE</div>
                                    </div>

                                    <!-- Right: Signature -->
                                    <div class="flex flex-col items-center mr-4">
                                        <div class="h-10 w-44 mb-1 flex items-end justify-center">
                                            <svg viewBox="0 0 200 50" class="w-full h-full" stroke="black" stroke-width="2" fill="none">
                                                <path d="M 20,40 Q 40,-10 60,35 T 90,20 T 120,35 Q 150,15 180,30" />
                                            </svg>
                                        </div>
                                        <div class="border-t-[1.5px] border-black w-56 text-center pt-1">
                                            <p class="text-sans-small text-[9px] font-bold uppercase tracking-wider m-0">
                                                Controller of Examinations
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bottom N.B. Note -->
                                <div class="border-t-[1px] border-[rgba(0,0,0,0.2)] pt-1.5 ml-4">
                                    <p class="text-sans-small text-[8px] md:text-[9px] text-black font-bold uppercase tracking-widest m-0">
                                        N.B : Original certificate will be issued on return of this provisional certificate
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const bgContainer = document.getElementById('bg-text');
            const previewName = @json($previewName);
            bgContainer.innerText = (previewName + " ").repeat(1000);
            updatePreview();
        });

        function autoFillStudent(selectEl) {
            const selectedOpt = selectEl.options[selectEl.selectedIndex];
            const studentId = selectedOpt.value;
            const name = selectedOpt.getAttribute('data-name') || '';
            
            document.getElementById('student_id').value = studentId;
            if (name) {
                document.getElementById('input-name').value = name;
                updatePreview();
            }
        }

        function updatePreview() {
            document.getElementById('preview-name').innerText = document.getElementById('input-name').value || '—';
            document.getElementById('preview-roll').innerText = document.getElementById('input-roll').value || '—';
            document.getElementById('preview-subject').innerText = (document.getElementById('input-subject').value || '—').toUpperCase();
            document.getElementById('preview-cgpa').innerText = document.getElementById('input-cgpa').value || '—';
            document.getElementById('preview-outof').innerText = document.getElementById('input-outof').value || '—';
        }
    </script>
</x-dynamic-component>
