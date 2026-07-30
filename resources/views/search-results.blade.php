<x-home-layout>
    <!-- Header Banner -->
    <section class="bg-primary text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-primaryDark/50 mix-blend-multiply z-0"></div>
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="max-w-2xl">
                <span class="inline-block text-secondary font-bold uppercase tracking-widest text-xs mb-3">
                    Dhaka Global University Search
                </span>
                <h1 class="text-3xl md:text-5xl font-serif font-bold mb-4">
                    Search Results
                </h1>
                <p class="text-white/80 text-sm md:text-base leading-relaxed">
                    Showing results for keyword: <span class="text-secondary font-bold">"{{ $q }}"</span>
                </p>
            </div>
        </div>
    </section>

    <!-- Results Section -->
    <section class="py-16 bg-slate-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="space-y-12">
                
                <!-- Events Results -->
                <div>
                    <h2 class="text-xl md:text-2xl font-serif font-bold text-primary mb-6 border-b border-slate-200 pb-3 flex items-center gap-2">
                        <i class="ph ph-calendar text-secondary"></i> Campus Events ({{ $events->count() }})
                    </h2>
                    
                    @if($events->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($events as $event)
                                <div class="bg-white border border-slate-200 shadow-sm hover:shadow-md transition duration-300 flex flex-col group overflow-hidden">
                                    <div class="h-44 relative bg-slate-100 overflow-hidden shrink-0">
                                        @if($event->thumbnail)
                                            <img src="{{ asset($event->thumbnail) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i class="ph-bold ph-calendar text-4xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-5 flex-grow flex flex-col justify-between">
                                        <div>
                                            <span class="text-secondary text-[10px] font-bold uppercase tracking-widest mb-1.5 block">
                                                {{ $event->created_at->format('M d, Y') }}
                                            </span>
                                            <h3 class="text-sm font-bold text-primary mb-2 line-clamp-2 group-hover:text-secondary transition-colors">
                                                {{ $event->title }}
                                            </h3>
                                        </div>
                                        <a href="{{ route('events.show', $event) }}" class="text-primary font-bold text-xs hover:text-secondary transition block mt-4">
                                            Read More &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-400 text-xs italic">No campus events match your query.</p>
                    @endif
                </div>

                <!-- News Results -->
                <div>
                    <h2 class="text-xl md:text-2xl font-serif font-bold text-primary mb-6 border-b border-slate-200 pb-3 flex items-center gap-2">
                        <i class="ph ph-newspaper text-secondary"></i> News Articles ({{ $news->count() }})
                    </h2>

                    @if($news->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($news as $article)
                                <div class="bg-white border border-slate-200 shadow-sm hover:shadow-md transition duration-300 flex flex-col group overflow-hidden">
                                    <div class="h-44 relative bg-slate-100 overflow-hidden shrink-0">
                                        @if($article->thumbnail)
                                            <img src="{{ asset($article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i class="ph-bold ph-newspaper text-4xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-5 flex-grow flex flex-col justify-between">
                                        <div>
                                            <span class="text-secondary text-[10px] font-bold uppercase tracking-widest mb-1.5 block">
                                                {{ $article->created_at->format('M d, Y') }}
                                            </span>
                                            <h3 class="text-sm font-bold text-primary mb-2 line-clamp-2 group-hover:text-secondary transition-colors">
                                                {{ $article->title }}
                                            </h3>
                                        </div>
                                        <a href="{{ route('news.show', $article) }}" class="text-primary font-bold text-xs hover:text-secondary transition block mt-4">
                                            Read More &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-400 text-xs italic">No news articles match your query.</p>
                    @endif
                </div>

            </div>
        </div>
    </section>
</x-home-layout>
