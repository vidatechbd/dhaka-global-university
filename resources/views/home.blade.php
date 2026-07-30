<x-home-layout>
    <!-- Hero Section -->
    @if($setting->show_hero)
        <section class="relative w-full h-[85vh] min-h-[600px] flex items-center bg-primary overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="swiper heroSwiper w-full h-full">
                    <div class="swiper-wrapper">
                        @if($setting->hero_slides && count($setting->hero_slides) > 0)
                            @foreach($setting->hero_slides as $slide)
                                <div class="swiper-slide relative flex items-center">
                                    <img src="{{ Str::startsWith($slide['image'] ?? '', 'http') ? ($slide['image'] ?? '') : asset($slide['image'] ?? '') }}" alt="Slide" class="absolute inset-0 w-full h-full object-cover z-0">
                                    <div class="absolute inset-0 bg-primary/70 mix-blend-multiply z-10"></div>
                                    
                                    <!-- Dynamic Slide Content Overlay -->
                                    <div class="container mx-auto px-4 md:px-6 relative z-20 flex items-center h-full">
                                        <div class="max-w-2xl bg-white/95 backdrop-blur-sm p-8 md:p-12 border-l-8 border-secondary shadow-2xl">
                                            @if(!empty($slide['tag']))
                                                <span class="inline-block text-secondary font-bold uppercase tracking-widest text-sm mb-4">
                                                    {{ $slide['tag'] }}
                                                </span>
                                            @endif
                                            
                                            @if(!empty($slide['title']))
                                                <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary leading-tight mb-6">
                                                    {!! $slide['title'] !!}
                                                </h2>
                                            @endif

                                            @if(!empty($slide['description']))
                                                <p class="text-slate-600 mb-8 leading-relaxed font-medium">
                                                    {{ $slide['description'] }}
                                                </p>
                                            @endif

                                            <div class="flex flex-wrap gap-4">
                                                @if(!empty($slide['btn_text_1']))
                                                    <a href="{{ $slide['btn_url_1'] ?? '#' }}" class="bg-primary text-white px-8 py-3 rounded-none font-bold uppercase tracking-wider text-sm hover:bg-secondary transition-colors shadow-lg">
                                                        {{ $slide['btn_text_1'] }}
                                                    </a>
                                                @endif
                                                @if(!empty($slide['btn_text_2']))
                                                    <a href="{{ $slide['btn_url_2'] ?? '#' }}" class="bg-transparent text-primary border-2 border-primary px-8 py-3 rounded-none font-bold uppercase tracking-wider text-sm hover:bg-primary hover:text-white transition-colors">
                                                        {{ $slide['btn_text_2'] }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Fallback Slide -->
                            <div class="swiper-slide relative flex items-center">
                                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1920&q=80" alt="Graduation" class="absolute inset-0 w-full h-full object-cover z-0">
                                <div class="absolute inset-0 bg-primary/70 mix-blend-multiply z-10"></div>
                                <div class="container mx-auto px-4 md:px-6 relative z-20 flex items-center h-full">
                                    <div class="max-w-2xl bg-white/95 backdrop-blur-sm p-8 md:p-12 border-l-8 border-secondary shadow-2xl">
                                        <span class="inline-block text-secondary font-bold uppercase tracking-widest text-sm mb-4">Admissions Open</span>
                                        <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary leading-tight mb-6">Empowering Minds, <br> Building the Future.</h2>
                                        <p class="text-slate-600 mb-8 leading-relaxed font-medium">Welcome to our university portal. Select explore programs to begin your journey.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
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
    @endif

    <!-- About Section -->
    @if($setting->show_about)
        <section class="py-20 lg:py-24 bg-white relative">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex flex-col lg:flex-row gap-16 items-center">
                    
                    <div class="lg:w-1/2 relative reveal-on-scroll">
                        <!-- Clean image composition -->
                        <div class="relative w-full max-w-lg mx-auto">
                            @if($setting->about_image)
                                <img src="{{ Str::startsWith($setting->about_image, 'http') ? $setting->about_image : asset($setting->about_image) }}" alt="University Building" class="w-full h-auto shadow-xl rounded-none relative z-10">
                            @else
                                <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=800&q=80" alt="University Building" class="w-full h-auto shadow-xl rounded-none relative z-10">
                            @endif
                            <div class="absolute -bottom-6 -left-6 w-full h-full border-4 border-secondary z-0"></div>
                            
                            <!-- Floating Stat Box -->
                            @if($setting->about_years)
                                <div class="absolute -right-8 bottom-12 bg-primary text-white p-6 shadow-xl z-20 hidden md:block">
                                    <p class="text-4xl font-serif font-bold text-secondary mb-1">{{ $setting->about_years }}</p>
                                    <p class="text-xs font-bold uppercase tracking-widest text-white/80">Years of Academic <br>Excellence</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="lg:w-1/2 reveal-on-scroll reveal-delay-1">
                        @if($setting->about_tag)
                            <div class="flex items-center gap-4 mb-4">
                                <div class="h-px bg-secondary w-12"></div>
                                <span class="text-secondary font-bold uppercase tracking-widest text-sm">{{ $setting->about_tag }}</span>
                            </div>
                        @endif

                        @if($setting->about_title)
                            <h2 class="text-3xl lg:text-4xl font-serif font-bold text-primary mb-6 leading-tight">
                                {{ $setting->about_title }}
                            </h2>
                        @endif
                        
                        @if($setting->about_description)
                            <div class="space-y-4 text-slate-600 leading-relaxed mb-8 home-about-content">
                                {!! $setting->about_description !!}
                            </div>
                        @endif
                        
                        @if($setting->about_url)
                            <a href="{{ $setting->about_url }}" class="inline-flex items-center gap-2 text-primary font-bold hover:text-secondary transition group">
                                Read Our Full Story <i class="ph-bold ph-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Leadership Section -->
    @if($setting->show_leadership)
        <section class="py-20 bg-lightBg border-t border-slate-200">
            <div class="container mx-auto px-4 md:px-6">
                <div class="text-center max-w-3xl mx-auto mb-16 reveal-on-scroll">
                    <h2 class="text-3xl lg:text-4xl font-serif font-bold text-primary mb-4">{{ $setting->leadership_title ?? 'Leadership & Authorities' }}</h2>
                    <p class="text-slate-600">{{ $setting->leadership_description ?? 'Guided by visionary leaders dedicated to academic brilliance.' }}</p>
                    <div class="w-16 h-1 bg-secondary mx-auto mt-6"></div>
                </div>

                @if($setting->leadership_members && count($setting->leadership_members) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($setting->leadership_members as $index => $member)
                            @if(!empty($member['name']))
                                <div class="bg-white p-6 shadow-md border border-slate-100 text-center group hover:-translate-y-2 transition-transform duration-300 reveal-on-scroll reveal-delay-{{ $index }}">
                                    <div class="w-32 h-32 mx-auto mb-6 rounded-none overflow-hidden border-2 border-slate-100 p-1">
                                        @if(!empty($member['image']))
                                            <img src="{{ Str::startsWith($member['image'], 'http') ? $member['image'] : asset($member['image']) }}" alt="{{ $member['name'] }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                        @else
                                            <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                                <i class="ph-bold ph-user text-4xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="font-serif font-bold text-primary text-lg mb-1">{{ $member['name'] }}</h3>
                                    <p class="text-secondary text-xs font-bold uppercase tracking-widest mb-4">{{ $member['designation'] ?? '' }}</p>
                                    <a href="{{ $member['message_url'] ?? '#' }}" class="text-primary text-sm font-medium hover:text-secondary transition">Read Message &rarr;</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Academic Faculties Section -->
    @if($setting->show_faculties)
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6 reveal-on-scroll">
                    <div>
                        <div class="flex items-center gap-4 mb-2">
                            <div class="h-px bg-secondary w-12"></div>
                            <span class="text-secondary font-bold uppercase tracking-widest text-sm">Programs</span>
                        </div>
                        <h2 class="text-3xl lg:text-4xl font-serif font-bold text-primary">{{ $setting->faculties_title ?? 'Academic Faculties' }}</h2>
                    </div>
                    @if($setting->faculties_btn_text)
                        <a href="{{ $setting->faculties_btn_url ?? '#' }}" class="bg-transparent border-2 border-primary text-primary px-6 py-2 rounded-none font-bold uppercase tracking-wider text-xs hover:bg-primary hover:text-white transition-colors">
                            {{ $setting->faculties_btn_text }}
                        </a>
                    @endif
                </div>

                @if($setting->faculties && count($setting->faculties) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($setting->faculties as $index => $faculty)
                            @if(!empty($faculty['name']))
                                <div class="group relative overflow-hidden shadow-lg reveal-on-scroll reveal-delay-{{ $index }}">
                                    <div class="h-64 relative overflow-hidden">
                                        @if(!empty($faculty['image']))
                                            <img src="{{ Str::startsWith($faculty['image'], 'http') ? $faculty['image'] : asset($faculty['image']) }}" alt="{{ $faculty['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                        @else
                                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400">
                                                <i class="ph-bold ph-graduation-cap text-5xl"></i>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                            <a href="{{ $faculty['explore_url'] ?? '#' }}" class="border-2 border-white text-white px-6 py-2 font-bold uppercase text-sm hover:bg-white hover:text-primary transition">Explore Faculty</a>
                                        </div>
                                    </div>
                                    <div class="bg-white border border-slate-200 border-t-0 p-6 {{ $index === 1 ? 'border-b-4 border-b-secondary' : '' }}">
                                        <h3 class="text-xl font-serif font-bold text-primary mb-3">{{ $faculty['name'] }}</h3>
                                        @if(!empty($faculty['depts']))
                                            <ul class="space-y-2 text-slate-600 text-sm">
                                                @foreach($faculty['depts'] as $dept)
                                                    <li class="flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> {{ $dept }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- News & Notice Section -->
    @if($setting->show_news_notice)
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
                                @if($news->count() > 0)
                                    @foreach($news->take(4) as $notice)
                                        <a href="{{ route('news.show', $notice) }}" class="block p-4 border border-slate-100 hover:border-secondary hover:shadow-md transition-all group bg-slate-50">
                                            <div class="text-xs font-bold text-secondary mb-1 flex items-center gap-1">
                                                <i class="ph-bold ph-calendar-blank"></i> 
                                                {{ $notice->created_at->format('d M Y') }}
                                            </div>
                                            <h4 class="text-primary font-medium group-hover:text-secondary transition-colors text-sm line-clamp-2">
                                                {{ $notice->title }}
                                            </h4>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="text-center py-8 text-slate-400 text-xs">No notices posted yet.</div>
                                @endif
                            </div>
                            <div class="p-4 border-t border-slate-200">
                                <a href="{{ route('news.index') }}" class="w-full py-2 bg-slate-100 text-primary font-bold text-center text-sm uppercase tracking-wider hover:bg-primary hover:text-white transition block border border-transparent">
                                    View All Notices
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Latest News -->
                    <div class="lg:col-span-8 flex flex-col reveal-on-scroll reveal-delay-1">
                        <div class="flex justify-between items-center mb-6 border-b border-slate-300 pb-3">
                            <h2 class="text-3xl font-serif font-bold text-primary">Campus News</h2>
                            <a href="{{ route('news.index') }}" class="text-secondary font-bold hover:text-primary transition flex items-center gap-1 text-sm uppercase tracking-widest">All News <i class="ph-bold ph-arrow-right"></i></a>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($news->count() > 0)
                                @foreach($news->take(2) as $newsItem)
                                    <div class="bg-white border border-slate-200 shadow-sm group overflow-hidden flex flex-col">
                                        <div class="h-48 relative overflow-hidden bg-slate-100">
                                            @if($newsItem->thumbnail)
                                                <img src="{{ asset($newsItem->thumbnail) }}" alt="{{ $newsItem->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                    <i class="ph-bold ph-image text-5xl"></i>
                                                </div>
                                            @endif
                                            <div class="absolute top-4 left-4 bg-secondary text-white px-3 py-1 text-center shadow-md">
                                                <div class="font-bold text-lg leading-none">{{ $newsItem->created_at->format('d') }}</div>
                                                <div class="text-[10px] font-bold uppercase">{{ $newsItem->created_at->format('M') }}</div>
                                            </div>
                                        </div>
                                        <div class="p-6 flex-grow flex flex-col">
                                            <span class="text-secondary text-xs font-bold uppercase tracking-widest mb-2">Seminar</span>
                                            <h3 class="text-lg font-serif font-bold text-primary mb-3 group-hover:text-secondary transition-colors line-clamp-2">{{ $newsItem->title }}</h3>
                                            <p class="text-slate-600 text-sm mb-4 line-clamp-2 flex-grow">{{ strip_tags($newsItem->content) }}</p>
                                            <a href="{{ route('news.show', $newsItem) }}" class="text-primary font-bold text-sm flex items-center gap-1 group-hover:text-secondary transition w-max">Read More &rarr;</a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-span-2 text-center py-12 text-slate-400 text-xs">No campus news posted yet.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</x-home-layout>
