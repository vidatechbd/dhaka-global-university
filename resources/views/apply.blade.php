<x-home-layout>
    <!-- Header Banner -->
    <section class="bg-primary text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-primaryDark/50 mix-blend-multiply z-0"></div>
        <div class="container mx-auto px-4 md:px-6 relative z-10 text-center">
            <span class="inline-block text-secondary font-bold uppercase tracking-widest text-xs mb-3">
                Admission Portal
            </span>
            <h1 class="text-3xl md:text-5xl font-serif font-bold mb-4">
                Online Admission Registration
            </h1>
            <p class="text-white/80 text-sm md:text-base max-w-xl mx-auto leading-relaxed">
                Please fill in the form below carefully to register for online admission. Our administration office will review and process your application.
            </p>
        </div>
    </section>

    <!-- Form Section -->
    <section class="py-16 bg-slate-50">
        <div class="container mx-auto px-4 md:px-6 max-w-4xl">
            <div class="bg-white border border-slate-200 shadow-sm p-8 md:p-10">
                
                <div class="text-center mb-8 border-b border-slate-100 pb-6">
                    <h2 class="text-2xl font-serif font-bold text-primary">Registration for Online Admission</h2>
                    <p class="text-xs text-slate-500 mt-1">Fields marked with asterisk (*) are required</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 text-xs font-semibold rounded shadow-sm">
                        <p class="font-bold mb-1">Please fix the following validation errors:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('apply') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Personal Information Block -->
                    <div class="space-y-5">
                        <h3 class="text-sm font-serif font-bold text-primary border-b border-slate-100 pb-2 flex items-center gap-1.5">
                            <span class="w-1.5 h-3 bg-secondary inline-block"></span> Personal Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-xs font-semibold text-slate-600 mb-1">Name <span class="text-rose-500">*</span></label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required 
                                       class="w-full border border-slate-300 px-3 py-2 text-xs focus:border-secondary outline-none bg-white rounded shadow-sm"
                                       placeholder="Your Full Name">
                            </div>

                            <div>
                                <label for="mobile" class="block text-xs font-semibold text-slate-600 mb-1">Mobile No <span class="text-rose-500">*</span></label>
                                <input id="mobile" type="tel" name="mobile" value="{{ old('mobile') }}" required maxlength="11" minlength="11"
                                       inputmode="numeric"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       class="w-full border border-slate-300 px-3 py-2 text-xs focus:border-secondary outline-none bg-white rounded shadow-sm"
                                       placeholder="11-digit Mobile Number (e.g. 01712345678)">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-600 mb-1">E-mail Address <span class="text-rose-500">*</span></label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full border border-slate-300 px-3 py-2 text-xs focus:border-secondary outline-none bg-white rounded shadow-sm"
                                   placeholder="ex: myname@example.com">
                        </div>
                    </div>

                    <!-- Academic Choices -->
                    <div class="space-y-5">
                        <h3 class="text-sm font-serif font-bold text-primary border-b border-slate-100 pb-2 flex items-center gap-1.5">
                            <span class="w-1.5 h-3 bg-secondary inline-block"></span> Academic Program
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="program_type" class="block text-xs font-semibold text-slate-600 mb-1">Program you choose to pursue <span class="text-rose-500">*</span></label>
                                <select id="program_type" name="program_type" required 
                                        class="w-full border border-slate-300 px-3 py-2 text-xs focus:border-secondary outline-none bg-white rounded shadow-sm">
                                    <option value="">Please Select</option>
                                    <option value="BBA" {{ old('program_type') == 'BBA' ? 'selected' : '' }}>BBA</option>
                                    <option value="BA(Hons.)English" {{ old('program_type') == 'BA(Hons.)English' ? 'selected' : '' }}>BA(Hons.)English</option>
                                    <option value="LLB (Hons.)" {{ old('program_type') == 'LLB (Hons.)' ? 'selected' : '' }}>LLB (Hons.)</option>
                                    <option value="B.Sc in CSE" {{ old('program_type') == 'B.Sc in CSE' ? 'selected' : '' }}>B.Sc in CSE</option>
                                    <option value="B.Sc in CSE (Diploma)" {{ old('program_type') == 'B.Sc in CSE (Diploma)' ? 'selected' : '' }}>B.Sc in CSE (Diploma)</option>
                                    <option value="B.Sc in EEE" {{ old('program_type') == 'B.Sc in EEE' ? 'selected' : '' }}>B.Sc in EEE</option>
                                    <option value="B.Sc in EEE (Diploma)" {{ old('program_type') == 'B.Sc in EEE (Diploma)' ? 'selected' : '' }}>B.Sc in EEE (Diploma)</option>
                                    <option value="B.Sc in Civil" {{ old('program_type') == 'B.Sc in Civil' ? 'selected' : '' }}>B.Sc in Civil</option>
                                    <option value="B.Sc in Civil (Diploma)" {{ old('program_type') == 'B.Sc in Civil (Diploma)' ? 'selected' : '' }}>B.Sc in Civil (Diploma)</option>
                                    <option value="MBA" {{ old('program_type') == 'MBA' ? 'selected' : '' }}>MBA</option>
                                    <option value="EMBA" {{ old('program_type') == 'EMBA' ? 'selected' : '' }}>EMBA</option>
                                    <option value="MBA (One Year)" {{ old('program_type') == 'MBA (One Year)' ? 'selected' : '' }}>MBA (One Year)</option>
                                    <option value="MAE (Two Years)" {{ old('program_type') == 'MAE (Two Years)' ? 'selected' : '' }}>MAE (Two Years)</option>
                                    <option value="MAE (One Year)" {{ old('program_type') == 'MAE (One Year)' ? 'selected' : '' }}>MAE (One Year)</option>
                                    <option value="MSc in Mathematics (One Year)" {{ old('program_type') == 'MSc in Mathematics (One Year)' ? 'selected' : '' }}>MSc in Mathematics (One Year)</option>
                                    <option value="MSc in Mathematics (Two Years)" {{ old('program_type') == 'MSc in Mathematics (Two Years)' ? 'selected' : '' }}>MSc in Mathematics (Two Years)</option>
                                    <option value="PGD in LIS (One Year)" {{ old('program_type') == 'PGD in LIS (One Year)' ? 'selected' : '' }}>PGD in LIS (One Year)</option>
                                </select>
                            </div>

                            <div>
                                <span class="block text-xs font-semibold text-slate-600 mb-2">Admission Type <span class="text-rose-500">*</span></span>
                                <div class="flex flex-wrap gap-4 mt-1">
                                    <label class="inline-flex items-center text-xs font-medium text-slate-700 cursor-pointer">
                                        <input type="radio" name="admission_type" value="Regular/ Undergraduate" class="text-secondary focus:ring-secondary border-slate-300" {{ old('admission_type') === 'Regular/ Undergraduate' || !old('admission_type') ? 'checked' : '' }}>
                                        <span class="ml-1.5">Regular/ Undergraduate</span>
                                    </label>
                                    <label class="inline-flex items-center text-xs font-medium text-slate-700 cursor-pointer">
                                        <input type="radio" name="admission_type" value="Diploma" class="text-secondary focus:ring-secondary border-slate-300" {{ old('admission_type') === 'Diploma' ? 'checked' : '' }}>
                                        <span class="ml-1.5">Diploma</span>
                                    </label>
                                    <label class="inline-flex items-center text-xs font-medium text-slate-700 cursor-pointer">
                                        <input type="radio" name="admission_type" value="Credit Transfered" class="text-secondary focus:ring-secondary border-slate-300" {{ old('admission_type') === 'Credit Transfered' ? 'checked' : '' }}>
                                        <span class="ml-1.5">Credit Transferred</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Records -->
                    <div class="space-y-5">
                        <h3 class="text-sm font-serif font-bold text-primary border-b border-slate-100 pb-2 flex items-center gap-1.5">
                            <span class="w-1.5 h-3 bg-secondary inline-block"></span> Academic Records
                        </h3>

                        <div class="space-y-4">
                            <!-- SSC -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="ssc_or_equivalent" class="block text-xs font-semibold text-slate-500 mb-1">SSC / O'Level / Equivalent Exam <span class="text-rose-500">*</span></label>
                                    <input id="ssc_or_equivalent" type="text" name="ssc_or_equivalent" value="{{ old('ssc_or_equivalent') }}" required
                                           class="w-full border border-slate-300 px-3 py-2 text-xs focus:border-secondary outline-none bg-white rounded shadow-sm"
                                           placeholder="e.g. SSC Science / O'Levels">
                                </div>
                                <div>
                                    <label for="ssc_division_or_gpa" class="block text-xs font-semibold text-slate-500 mb-1">SSC Division / GPA <span class="text-rose-500">*</span></label>
                                    <input id="ssc_division_or_gpa" type="text" name="ssc_division_or_gpa" value="{{ old('ssc_division_or_gpa') }}" required
                                           class="w-full border border-slate-300 px-3 py-2 text-xs focus:border-secondary outline-none bg-white rounded shadow-sm"
                                           placeholder="e.g. 5.00 / 1st Division">
                                </div>
                            </div>

                            <!-- HSC -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="hsc_or_equivalent" class="block text-xs font-semibold text-slate-500 mb-1">HSC / Diploma / Equivalent Exam <span class="text-rose-500">*</span></label>
                                    <input id="hsc_or_equivalent" type="text" name="hsc_or_equivalent" value="{{ old('hsc_or_equivalent') }}" required
                                           class="w-full border border-slate-300 px-3 py-2 text-xs focus:border-secondary outline-none bg-white rounded shadow-sm"
                                           placeholder="e.g. HSC Science / Diploma in Engineering">
                                </div>
                                <div>
                                    <label for="hsc_division_or_gpa" class="block text-xs font-semibold text-slate-500 mb-1">HSC Division / GPA <span class="text-rose-500">*</span></label>
                                    <input id="hsc_division_or_gpa" type="text" name="hsc_division_or_gpa" value="{{ old('hsc_division_or_gpa') }}" required
                                           class="w-full border border-slate-300 px-3 py-2 text-xs focus:border-secondary outline-none bg-white rounded shadow-sm"
                                           placeholder="e.g. 4.90 / 1st Division">
                                </div>
                            </div>

                            <!-- Bachelor -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="bachelor_or_degree_hons" class="block text-xs font-semibold text-slate-500 mb-1">Bachelor's Degree / Equivalent Exam (If applicable)</label>
                                    <input id="bachelor_or_degree_hons" type="text" name="bachelor_or_degree_hons" value="{{ old('bachelor_or_degree_hons') }}"
                                           class="w-full border border-slate-300 px-3 py-2 text-xs focus:border-secondary outline-none bg-white rounded shadow-sm"
                                           placeholder="e.g. BSc in CSE">
                                </div>
                                <div>
                                    <label for="bachelor_division_or_gpa" class="block text-xs font-semibold text-slate-500 mb-1">Bachelor Division / CGPA (If applicable)</label>
                                    <input id="bachelor_division_or_gpa" type="text" name="bachelor_division_or_gpa" value="{{ old('bachelor_division_or_gpa') }}"
                                           class="w-full border border-slate-300 px-3 py-2 text-xs focus:border-secondary outline-none bg-white rounded shadow-sm"
                                           placeholder="e.g. 3.85 / 1st Class">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider & Scholarship info -->
                    <div class="pt-4 border-t border-slate-100 text-center space-y-4">
                        <div class="bg-amber-50 border border-amber-200 text-amber-800 text-[11px] font-bold p-3 rounded leading-relaxed uppercase tracking-wider">
                            NB: Up to 100% scholarship based on merit. And Up to 18% group waiver on tuition fee for Summer Semester. (Conditions Apply)
                        </div>
                        <div class="text-[10px] text-slate-400 font-semibold">
                            Admission Office Contact: 018-650-41805, 018-650-41804 | Email: info@feniuniversity.edu.bd
                        </div>
                    </div>

                    <!-- Form Buttons -->
                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                        <button type="button" onclick="window.print()" class="px-4 py-2 border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold transition flex items-center gap-1">
                            <i class="ph ph-printer"></i> Print Form
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-secondary text-white text-xs font-bold shadow-md transition">
                            Submit Application
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </section>
</x-home-layout>
