<!-- Top Bar -->
<div class="bg-primaryDark text-white/80 py-2 text-xs sm:text-sm font-medium">
    <div class="container mx-auto px-4 md:px-6 flex flex-col sm:flex-row justify-between items-center">
        <div class="flex space-x-6 mb-2 sm:mb-0">
            <a href="mailto:registrar@feniuniversity.ac.bd" class="hover:text-white transition flex items-center gap-2">
                <i class="ph ph-envelope-simple"></i> registrar@feniuniversity.ac.bd
            </a>
            <a href="tel:02334474194" class="hover:text-white transition flex items-center gap-2">
                <i class="ph ph-phone"></i> 02334474194
            </a>
        </div>
        <div class="flex items-center space-x-6">
            <a href="/career" class="hover:text-white transition hidden md:block">Career</a>
            <a href="/alumni" class="hover:text-white transition hidden md:block">Alumni</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="hover:text-white transition flex items-center gap-1 font-bold text-secondary">
                    <i class="ph ph-user"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="hover:text-white transition flex items-center gap-1 font-bold text-secondary">
                    <i class="ph ph-sign-in"></i> Log In
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="hover:text-white transition flex items-center gap-1 font-bold text-secondary">
                        <i class="ph ph-user-plus"></i> Register
                    </a>
                @endif
            @endauth
        </div>
    </div>
</div>

<!-- Main Navigation -->
<header class="bg-white shadow-md sticky top-0 z-50 transition-all duration-300" id="main-header">
    <div class="container mx-auto px-4 md:px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-3">
            <div class="w-12 h-12 bg-primary flex items-center justify-center text-white font-serif font-bold text-xl rounded-none">
                FU
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-serif font-bold text-primary tracking-tight leading-none uppercase">Feni University</h1>
                <p class="text-[10px] md:text-xs text-slate-500 font-semibold uppercase tracking-widest mt-1">Center for Learning</p>
            </div>
        </a>

        <!-- Mobile Menu Btn -->
        <button id="mobile-menu-btn" class="lg:hidden text-primary p-2 hover:bg-slate-100 transition rounded-none border border-transparent">
            <i class="ph ph-list text-2xl"></i>
        </button>

        <!-- Desktop Nav -->
        <nav class="hidden lg:flex items-center space-x-6 font-semibold text-sm text-primary">
            <a href="/" class="hover:text-secondary transition py-2">Home</a>
            
            <!-- Mega Menu: About -->
            <div class="group relative group-hover:show-mega py-2">
                <button class="hover:text-secondary transition flex items-center gap-1 uppercase tracking-wide">
                    About <i class="ph ph-caret-down text-xs transition-transform group-hover:rotate-180"></i>
                </button>
                <!-- Mega Menu Dropdown -->
                <div class="mega-menu absolute top-full left-0 mt-0 w-[750px] lg:w-[800px] bg-white border-t-4 border-secondary shadow-2xl p-8 grid grid-cols-3 gap-8 rounded-none z-50">
                    <!-- Column 1 -->
                    <div>
                        <h4 class="text-primary font-serif font-bold text-lg border-b border-slate-200 pb-2 mb-4 flex items-center gap-2">
                            <i class="ph-duotone ph-buildings text-secondary text-xl"></i> University
                        </h4>
                        <ul class="space-y-3 font-normal text-slate-600">
                            <li><a href="#" class="hover:text-secondary transition block">About FU</a></li>
                            <li><a href="#" class="hover:text-secondary transition block">Vision & Mission</a></li>
                            <li><a href="#" class="hover:text-secondary transition block">Permanent Campus</a></li>
                            <li><a href="#" class="hover:text-secondary transition block">Campus Facilities</a></li>
                        </ul>
                    </div>
                    <!-- Column 2 -->
                    <div>
                        <h4 class="text-primary font-serif font-bold text-lg border-b border-slate-200 pb-2 mb-4 flex items-center gap-2">
                            <i class="ph-duotone ph-users-three text-secondary text-xl"></i> Administration
                        </h4>
                        <ul class="space-y-3 font-normal text-slate-600">
                            <li><a href="#" class="hover:text-secondary transition block">Board of Trustees</a></li>
                            <li><a href="#" class="hover:text-secondary transition block">Vice Chancellor</a></li>
                            <li><a href="#" class="hover:text-secondary transition block">Treasurer</a></li>
                            <li><a href="#" class="hover:text-secondary transition block">Registrar Office</a></li>
                            <li><a href="#" class="hover:text-secondary transition block">Syndicate</a></li>
                        </ul>
                    </div>
                    <!-- Column 3 -->
                    <div class="bg-slate-50 p-6 -m-4 border border-slate-100 flex flex-col justify-center">
                        <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=400&q=80" alt="Campus" class="w-full h-32 object-cover mb-4 grayscale hover:grayscale-0 transition-all duration-500">
                        <h5 class="font-serif font-bold text-primary mb-2">Explore Our Campus</h5>
                        <p class="text-xs text-slate-500 mb-4">Discover the vibrant life and modern facilities at Feni University.</p>
                        <a href="#" class="text-sm text-secondary font-bold hover:text-primary transition flex items-center gap-1">View Gallery <i class="ph-bold ph-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Academic Dropdown (Standard) -->
            <div class="group relative py-2">
                <button class="hover:text-secondary transition flex items-center gap-1 uppercase tracking-wide">
                    Academic <i class="ph ph-caret-down text-xs transition-transform group-hover:rotate-180"></i>
                </button>
                <div class="absolute top-full left-0 mt-0 w-64 bg-white border-t-4 border-primary shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 flex flex-col rounded-none z-50">
                    <a href="#" class="px-6 py-3 border-b border-slate-100 hover:bg-slate-50 hover:text-secondary transition text-slate-700 font-medium block">Faculty of Arts & Law</a>
                    <a href="#" class="px-6 py-3 border-b border-slate-100 hover:bg-slate-50 hover:text-secondary transition text-slate-700 font-medium block">Faculty of Business Admin</a>
                    <a href="#" class="px-6 py-3 hover:bg-slate-50 hover:text-secondary transition text-slate-700 font-medium block">Faculty of Science & Eng.</a>
                </div>
            </div>
            
            <a href="#" class="hover:text-secondary transition uppercase tracking-wide py-2">Admission</a>
            <a href="#" class="hover:text-secondary transition uppercase tracking-wide py-2">Research</a>
            <a href="#" class="hover:text-secondary transition uppercase tracking-wide py-2">IQAC</a>
            
            <div class="pl-4 border-l border-slate-200 flex items-center gap-4">
                <div class="flex items-center relative">
                    <input type="text" id="desktop-search-input" class="absolute right-full mr-2 w-0 opacity-0 transition-all duration-300 outline-none border-b border-primary text-sm bg-white py-1 pointer-events-none focus:border-secondary text-slate-700" placeholder="Search courses, news...">
                    <button id="desktop-search-btn" class="text-primary hover:text-secondary transition bg-white z-10 relative p-1 flex items-center justify-center">
                        <i class="ph ph-magnifying-glass text-xl"></i>
                    </button>
                </div>
                <a href="#" class="bg-secondary text-white px-6 py-2 rounded-none hover:bg-primary transition shadow-md font-bold uppercase tracking-wider text-xs whitespace-nowrap">Apply Now</a>
            </div>
        </nav>
    </div>

    <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-100 bg-white">
        <div class="container mx-auto px-4 py-4 flex flex-col space-y-2 font-medium text-primary">
            <a href="/" class="p-2 border-b border-slate-100">Home</a>
            <a href="#" class="p-2 border-b border-slate-100">About FU</a>
            <a href="#" class="p-2 border-b border-slate-100">Academic</a>
            <a href="#" class="p-2 border-b border-slate-100">Admission</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="p-2 bg-secondary text-white text-center mt-4 font-bold uppercase">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="p-2 bg-secondary text-white text-center mt-4 font-bold uppercase">Log In</a>
            @endauth
        </div>
    </div>
</header>
