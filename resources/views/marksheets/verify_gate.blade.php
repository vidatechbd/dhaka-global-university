<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Academic Transcript - {{ $setting->name ?? 'Dhaka Global University' }}</title>
    
    @if($setting && $setting->favicon)
        <link rel="shortcut icon" href="{{ asset($setting->favicon) }}" type="image/x-icon">
        <link rel="icon" href="{{ asset($setting->favicon) }}" type="image/x-icon">
    @endif

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0a3a60',
                        primaryDark: '#072740',
                        secondary: '#f7941d',
                        secondaryDark: '#d97d10',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Merriweather', 'serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-tr from-[#f1f5f9] to-[#e2e8f0] font-sans min-h-screen flex flex-col items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden transition-all duration-300 hover:shadow-2xl">
        
        <!-- Header Section with logo / branding -->
        <div class="bg-gradient-to-b from-primary to-primaryDark p-8 text-center relative overflow-hidden">
            <!-- Background Accent Shape -->
            <div class="absolute -right-16 -top-16 w-36 h-36 rounded-full bg-white/5 pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-36 h-36 rounded-full bg-white/5 pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col items-center">
                @if($setting && $setting->logo)
                    <img src="{{ asset($setting->logo) }}" alt="Logo" class="h-16 object-contain mb-4 filter drop-shadow">
                @else
                    <div class="w-16 h-16 bg-secondary rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-secondary/20">
                        <span class="text-white text-3xl">🎓</span>
                    </div>
                @endif
                <h2 class="font-serif font-bold text-white text-lg tracking-tight">{{ $setting->name ?? 'Dhaka Global University' }}</h2>
                <p class="text-white/70 text-xs mt-1 font-medium tracking-wide uppercase">Academic Verification Gate</p>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('marksheets.verify', $marksheet) }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div class="text-center">
                <h3 class="text-base font-bold text-slate-800">Verify Academic Transcript / Marksheet</h3>
                <p class="text-xs text-slate-400 mt-1">Please enter the official credentials printed on the transcript to access the full document.</p>
            </div>

            <!-- Error Alerts -->
            @if($errors->has('verification'))
                <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold rounded-xl flex items-center gap-2.5">
                    <span class="text-sm">⚠️</span>
                    <span>{{ $errors->first('verification') }}</span>
                </div>
            @endif

            <div class="space-y-4">
                <!-- Exam Roll -->
                <div>
                    <label for="exam_roll" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Exam Roll Number</label>
                    <input 
                        type="text" 
                        name="exam_roll" 
                        id="exam_roll" 
                        value="{{ old('exam_roll') }}" 
                        placeholder="e.g. 46437" 
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 outline-none transition duration-200 focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary text-xs font-semibold shadow-sm"
                        required
                    >
                    @error('exam_roll')
                        <p class="text-rose-600 text-[10px] mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Registration No -->
                <div>
                    <label for="reg_no" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Registration Number</label>
                    <input 
                        type="text" 
                        name="reg_no" 
                        id="reg_no" 
                        value="{{ old('reg_no') }}" 
                        placeholder="e.g. 1502046437" 
                        class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 outline-none transition duration-200 focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary text-xs font-semibold shadow-sm"
                        required
                    >
                    @error('reg_no')
                        <p class="text-rose-600 text-[10px] mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button 
                    type="submit" 
                    class="w-full bg-primary hover:bg-primaryDark text-white py-3 rounded-xl font-bold transition duration-200 flex items-center justify-center gap-2 shadow-lg shadow-primary/20 text-xs cursor-pointer hover:translate-y-[-1px] active:translate-y-[0px]"
                >
                    Verify & View Transcript
                </button>
            </div>
        </form>

        <!-- Footer Info -->
        <div class="border-t border-slate-100 bg-slate-50/50 px-8 py-4 flex justify-between items-center text-[10px] text-slate-400">
            <p>&copy; {{ date('Y') }} {{ $setting->name ?? 'Dhaka Global University' }}</p>
            <p class="font-semibold text-primary">Secure Verification System</p>
        </div>

    </div>

</body>
</html>
