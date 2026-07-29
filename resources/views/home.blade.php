<x-home-layout>
    <!-- Hero Section -->
    <section class="relative w-full h-[85vh] min-h-[600px] flex items-center bg-primary overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="swiper heroSwiper w-full h-full">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide relative">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1920&q=80" alt="Graduation" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-primary/70 mix-blend-multiply"></div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="swiper-slide relative">
                        <img src="https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1920&q=80" alt="Campus Life" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-primary/70 mix-blend-multiply"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Content Overlay (Clean Box) -->
        <div class="container mx-auto px-4 md:px-6 relative z-10 flex items-center h-full">
            <div class="max-w-2xl bg-white/95 backdrop-blur-sm p-8 md:p-12 border-l-8 border-secondary shadow-2xl reveal-on-scroll">
                <span class="inline-block text-secondary font-bold uppercase tracking-widest text-sm mb-4">
                    Fall 2026 Admissions Open
                </span>
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary leading-tight mb-6">
                    Empowering Minds, <br>
                    Building the Future.
                </h2>
                <p class="text-slate-600 mb-8 leading-relaxed font-medium">
                    Welcome to Feni University. We are committed to academic excellence, ethical standards, and producing leaders for tomorrow's challenges.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#" class="bg-primary text-white px-8 py-3 rounded-none font-bold uppercase tracking-wider text-sm hover:bg-secondary transition-colors shadow-lg">
                        Explore Programs
                    </a>
                    <a href="#" class="bg-transparent text-primary border-2 border-primary px-8 py-3 rounded-none font-bold uppercase tracking-wider text-sm hover:bg-primary hover:text-white transition-colors">
                        Virtual Tour
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Swiper Controls -->
        <div class="absolute bottom-8 right-8 z-20 flex gap-2">
            <button class="hero-prev w-12 h-12 bg-white text-primary flex items-center justify-center hover:bg-secondary hover:text-white transition-colors border border-slate-200">
                <i class="ph-bold ph-arrow-left"></i>
            </button>
            <button class="hero-next w-12 h-12 bg-white text-primary flex items-center justify-center hover:bg-secondary hover:text-white transition-colors border border-slate-200">
                <i class="ph-bold ph-arrow-right"></i>
            </button>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-20 lg:py-24 bg-white relative">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col lg:flex-row gap-16 items-center">
                
                <div class="lg:w-1/2 relative reveal-on-scroll">
                    <!-- Clean image composition -->
                    <div class="relative w-full max-w-lg mx-auto">
                        <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=800&q=80" alt="University Building" class="w-full h-auto shadow-xl rounded-none relative z-10">
                        <div class="absolute -bottom-6 -left-6 w-full h-full border-4 border-secondary z-0"></div>
                        
                        <!-- Floating Stat Box -->
                        <div class="absolute -right-8 bottom-12 bg-primary text-white p-6 shadow-xl z-20 hidden md:block">
                            <p class="text-4xl font-serif font-bold text-secondary mb-1">11+</p>
                            <p class="text-xs font-bold uppercase tracking-widest text-white/80">Years of Academic <br>Excellence</p>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2 reveal-on-scroll reveal-delay-1">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-px bg-secondary w-12"></div>
                        <span class="text-secondary font-bold uppercase tracking-widest text-sm">About Feni University</span>
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-serif font-bold text-primary mb-6 leading-tight">
                        A Center for Quality Education & Ethical Standards.
                    </h2>
                    
                    <div class="space-y-4 text-slate-600 leading-relaxed mb-8">
                        <p>
                            <strong class="text-primary font-semibold">Feni University (FU)</strong> started its academic activities with a vision to promote ethical standards and flourish as a center of excellence in higher education in the country.
                        </p>
                        <p>
                            It is the first private university in the greater Noakhali region, aiming to provide tertiary level education at an affordable cost without compromising quality. Our dynamic faculty and modern facilities ensure students are prepared for global challenges.
                        </p>
                    </div>
                    
                    <a href="#" class="inline-flex items-center gap-2 text-primary font-bold hover:text-secondary transition group">
                        Read Our Full Story <i class="ph-bold ph-arrow-right group-hover:translate-x-2 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Section -->
    <section class="py-20 bg-lightBg border-t border-slate-200">
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal-on-scroll">
                <h2 class="text-3xl lg:text-4xl font-serif font-bold text-primary mb-4">Leadership & Authorities</h2>
                <p class="text-slate-600">Guided by visionary leaders dedicated to academic brilliance and institutional integrity.</p>
                <div class="w-16 h-1 bg-secondary mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="bg-white p-6 shadow-md border border-slate-100 text-center group hover:-translate-y-2 transition-transform duration-300 reveal-on-scroll">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-none overflow-hidden border-2 border-slate-100 p-1">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=256&q=80" alt="Chairman" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                    </div>
                    <h3 class="font-serif font-bold text-primary text-lg mb-1">Brig. Gen. (Rtd.) Nasir Uddin</h3>
                    <p class="text-secondary text-xs font-bold uppercase tracking-widest mb-4">Chairman, BOT</p>
                    <a href="#" class="text-primary text-sm font-medium hover:text-secondary transition">Read Message &rarr;</a>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 shadow-md border border-slate-100 text-center group hover:-translate-y-2 transition-transform duration-300 reveal-on-scroll reveal-delay-1">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-none overflow-hidden border-2 border-slate-100 p-1">
                        <img src="https://images.unsplash.com/photo-1556157382-97eda2d62296?auto=format&fit=crop&w=256&q=80" alt="VC" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                    </div>
                    <h3 class="font-serif font-bold text-primary text-lg mb-1">Prof. Dr. Md. Fazli Ilahi</h3>
                    <p class="text-secondary text-xs font-bold uppercase tracking-widest mb-4">Vice Chancellor</p>
                    <a href="#" class="text-primary text-sm font-medium hover:text-secondary transition">Read Message &rarr;</a>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 shadow-md border border-slate-100 text-center group hover:-translate-y-2 transition-transform duration-300 reveal-on-scroll reveal-delay-2">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-none overflow-hidden border-2 border-slate-100 p-1">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=256&q=80" alt="Treasurer" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                    </div>
                    <h3 class="font-serif font-bold text-primary text-lg mb-1">Prof. Dr. Tayabul Haq</h3>
                    <p class="text-secondary text-xs font-bold uppercase tracking-widest mb-4">Treasurer</p>
                    <a href="#" class="text-primary text-sm font-medium hover:text-secondary transition">Read Message &rarr;</a>
                </div>

                <!-- Card 4 -->
                <div class="bg-white p-6 shadow-md border border-slate-100 text-center group hover:-translate-y-2 transition-transform duration-300 reveal-on-scroll reveal-delay-2">
                    <div class="w-32 h-32 mx-auto mb-6 rounded-none overflow-hidden border-2 border-slate-100 p-1">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=256&q=80" alt="Registrar" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                    </div>
                    <h3 class="font-serif font-bold text-primary text-lg mb-1">A S M Abul Khair</h3>
                    <p class="text-secondary text-xs font-bold uppercase tracking-widest mb-4">Registrar</p>
                    <a href="#" class="text-primary text-sm font-medium hover:text-secondary transition">View Profile &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Academic Faculties Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6 reveal-on-scroll">
                <div>
                    <div class="flex items-center gap-4 mb-2">
                        <div class="h-px bg-secondary w-12"></div>
                        <span class="text-secondary font-bold uppercase tracking-widest text-sm">Programs</span>
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-serif font-bold text-primary">Academic Faculties</h2>
                </div>
                <a href="#" class="bg-transparent border-2 border-primary text-primary px-6 py-2 rounded-none font-bold uppercase tracking-wider text-xs hover:bg-primary hover:text-white transition-colors">
                    View All Programs
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Faculty 1 -->
                <div class="group relative overflow-hidden shadow-lg reveal-on-scroll">
                    <div class="h-64 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <a href="#" class="border-2 border-white text-white px-6 py-2 font-bold uppercase text-sm hover:bg-white hover:text-primary transition">Explore Faculty</a>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-200 border-t-0 p-6">
                        <h3 class="text-xl font-serif font-bold text-primary mb-3">Arts, Social Science & Law</h3>
                        <ul class="space-y-2 text-slate-600 text-sm">
                            <li class="flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Dept. of English</li>
                            <li class="flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Dept. of Law</li>
                        </ul>
                    </div>
                </div>

                <!-- Faculty 2 -->
                <div class="group relative overflow-hidden shadow-lg reveal-on-scroll reveal-delay-1">
                    <div class="h-64 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1434626881859-194d67b2b86f?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <a href="#" class="border-2 border-white text-white px-6 py-2 font-bold uppercase text-sm hover:bg-white hover:text-primary transition">Explore Faculty</a>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-200 border-t-0 p-6 border-b-4 border-b-secondary">
                        <h3 class="text-xl font-serif font-bold text-primary mb-3">Business Administration</h3>
                        <ul class="space-y-2 text-slate-600 text-sm">
                            <li class="flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> BBA Program</li>
                            <li class="flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> MBA (Regular & Executive)</li>
                        </ul>
                    </div>
                </div>

                <!-- Faculty 3 -->
                <div class="group relative overflow-hidden shadow-lg reveal-on-scroll reveal-delay-2">
                    <div class="h-64 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <a href="#" class="border-2 border-white text-white px-6 py-2 font-bold uppercase text-sm hover:bg-white hover:text-primary transition">Explore Faculty</a>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-200 border-t-0 p-6">
                        <h3 class="text-xl font-serif font-bold text-primary mb-3">Science & Engineering</h3>
                        <ul class="space-y-2 text-slate-600 text-sm">
                            <li class="flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Computer Science (CSE)</li>
                            <li class="flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Civil Engineering (CE)</li>
                            <li class="flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> EEE</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News & Notice Section -->
    <section class="py-20 bg-lightBg border-t border-slate-200">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <!-- Notice Board -->
                <div class="lg:col-span-4 reveal-on-scroll">
                    <div class="bg-primary text-white p-4 flex items-center gap-3">
                        <i class="ph-bold ph-bell-ringing text-2xl text-secondary"></i>
                        <h2 class="text-xl font-serif font-bold">Notice Board</h2>
                    </div>
                    
                    <div class="bg-white border border-slate-200 border-t-0 h-[450px] flex flex-col shadow-sm">
                        <div class="flex-grow overflow-y-auto notice-list p-4 space-y-3">
                            <!-- Notice Items -->
                            <a href="#" class="block p-4 border border-slate-100 hover:border-secondary hover:shadow-md transition-all group bg-slate-50">
                                <div class="text-xs font-bold text-secondary mb-1 flex items-center gap-1"><i class="ph-bold ph-calendar-blank"></i> 25 Jun 2026</div>
                                <h4 class="text-primary font-medium group-hover:text-secondary transition-colors text-sm">Ashura Holiday and Spring Semester Break 2026</h4>
                            </a>
                            <a href="#" class="block p-4 border border-slate-100 hover:border-secondary hover:shadow-md transition-all group bg-slate-50">
                                <div class="text-xs font-bold text-secondary mb-1 flex items-center gap-1"><i class="ph-bold ph-calendar-blank"></i> 22 May 2026</div>
                                <h4 class="text-primary font-medium group-hover:text-secondary transition-colors text-sm">Holiday Notice on Eid-ul-Adha</h4>
                            </a>
                            <a href="#" class="block p-4 border border-slate-100 hover:border-secondary hover:shadow-md transition-all group bg-slate-50">
                                <div class="text-xs font-bold text-secondary mb-1 flex items-center gap-1"><i class="ph-bold ph-calendar-blank"></i> 15 May 2026</div>
                                <h4 class="text-primary font-medium group-hover:text-secondary transition-colors text-sm">Final Examinations of Spring Semester</h4>
                            </a>
                            <a href="#" class="block p-4 border border-slate-100 hover:border-secondary hover:shadow-md transition-all group bg-slate-50">
                                <div class="text-xs font-bold text-secondary mb-1 flex items-center gap-1"><i class="ph-bold ph-calendar-blank"></i> 10 May 2026</div>
                                <h4 class="text-primary font-medium group-hover:text-secondary transition-colors text-sm">Semester Fee Payment Deadline Notice</h4>
                            </a>
                        </div>
                        <div class="p-4 border-t border-slate-200">
                            <a href="#" class="w-full py-2 bg-slate-100 text-primary font-bold text-center text-sm uppercase tracking-wider hover:bg-primary hover:text-white transition block border border-transparent">
                                View All Notices
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Latest News -->
                <div class="lg:col-span-8 flex flex-col reveal-on-scroll reveal-delay-1">
                    <div class="flex justify-between items-center mb-6 border-b border-slate-300 pb-3">
                        <h2 class="text-3xl font-serif font-bold text-primary">Campus News</h2>
                        <a href="#" class="text-secondary font-bold hover:text-primary transition flex items-center gap-1 text-sm uppercase tracking-widest">All News <i class="ph-bold ph-arrow-right"></i></a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- News Card 1 -->
                        <div class="bg-white border border-slate-200 shadow-sm group overflow-hidden flex flex-col">
                            <div class="h-48 relative overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute top-4 left-4 bg-secondary text-white px-3 py-1 text-center shadow-md">
                                    <div class="font-bold text-lg leading-none">23</div>
                                    <div class="text-[10px] font-bold uppercase">May</div>
                                </div>
                            </div>
                            <div class="p-6 flex-grow flex flex-col">
                                <span class="text-secondary text-xs font-bold uppercase tracking-widest mb-2">Seminar</span>
                                <h3 class="text-lg font-serif font-bold text-primary mb-3 group-hover:text-secondary transition-colors line-clamp-2">Seminar on Career Building in Competitive World</h3>
                                <p class="text-slate-600 text-sm mb-4 line-clamp-2 flex-grow">Organized by the CSE Dept. to help students navigate the modern job market with essential skills.</p>
                                <a href="#" class="text-primary font-bold text-sm flex items-center gap-1 group-hover:text-secondary transition w-max">Read More &rarr;</a>
                            </div>
                        </div>

                        <!-- News Card 2 -->
                        <div class="bg-white border border-slate-200 shadow-sm group overflow-hidden flex flex-col">
                            <div class="h-48 relative overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1529070538774-1843cb166530?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute top-4 left-4 bg-primary text-white px-3 py-1 text-center shadow-md">
                                    <div class="font-bold text-lg leading-none">22</div>
                                    <div class="text-[10px] font-bold uppercase">May</div>
                                </div>
                            </div>
                            <div class="p-6 flex-grow flex flex-col">
                                <span class="text-secondary text-xs font-bold uppercase tracking-widest mb-2">Campus Life</span>
                                <h3 class="text-lg font-serif font-bold text-primary mb-3 group-hover:text-secondary transition-colors line-clamp-2">Human Chain Protest Against Violence</h3>
                                <p class="text-slate-600 text-sm mb-4 line-clamp-2 flex-grow">Students and faculty united to stand against violence and demand justice in a peaceful gathering.</p>
                                <a href="#" class="text-primary font-bold text-sm flex items-center gap-1 group-hover:text-secondary transition w-max">Read More &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-home-layout>
