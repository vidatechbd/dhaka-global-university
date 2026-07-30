<x-home-layout>
    <!-- Back to events / Breadcrumb -->
    <div class="bg-slate-100 border-b border-slate-200 py-4 no-print">
        <div class="container mx-auto px-4 md:px-6 flex items-center justify-between text-xs text-slate-500 font-semibold">
            <div class="flex items-center gap-2">
                <a href="/" class="hover:text-primary transition">Home</a>
                <span>/</span>
                <a href="{{ route('events.index') }}" class="hover:text-primary transition">Events</a>
                <span>/</span>
                <span class="text-slate-700 truncate max-w-xs">{{ $event->title }}</span>
            </div>
            <a href="{{ route('events.index') }}" class="hover:text-primary transition flex items-center gap-1 font-bold text-primary">
                &larr; Back to Events
            </a>
        </div>
    </div>

    <!-- Event Article & Sidebar Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Main Event Content -->
                <article class="lg:col-span-8 space-y-6">
                    <header class="space-y-4">
                        <span class="inline-block bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded">
                            {{ $event->created_at->format('F d, Y') }}
                        </span>
                        
                        <h1 class="text-2xl md:text-4xl font-serif font-bold text-primary leading-tight">
                            {{ $event->title }}
                        </h1>
                        
                        <div class="flex items-center gap-4 text-xs text-slate-400 border-b border-slate-100 pb-4 font-semibold">
                            <span class="flex items-center gap-1">
                                <i class="ph ph-user"></i> Posted by DGU Administration
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="ph ph-calendar"></i> {{ $event->created_at->format('h:i A') }}
                            </span>
                        </div>
                    </header>

                    @if($event->thumbnail)
                        <div class="w-full max-h-[450px] overflow-hidden bg-slate-100 border border-slate-200">
                            <img src="{{ asset($event->thumbnail) }}" alt="{{ $event->title }}" class="w-full h-auto object-cover">
                        </div>
                    @endif

                    <div class="text-slate-700 leading-relaxed text-sm md:text-base space-y-4 font-normal event-body-content">
                        {!! $event->content !!}
                    </div>
                </article>

                <!-- Sidebar Area -->
                <aside class="lg:col-span-4 space-y-8 no-print">
                    <!-- Search Widget -->
                    <div class="bg-slate-50 p-6 border border-slate-200 shadow-sm">
                        <h4 class="text-sm font-serif font-bold text-primary border-b border-slate-200 pb-2 mb-4">
                            Search Events
                        </h4>
                        <form action="{{ route('events.index') }}" method="GET" class="flex gap-2">
                            <input type="text" name="q" class="w-full border border-slate-300 text-xs px-3 py-2 outline-none focus:border-secondary text-slate-700 bg-white" placeholder="Keyword...">
                            <button type="submit" class="bg-primary hover:bg-secondary text-white px-4 py-2 font-bold text-xs uppercase transition">
                                Search
                            </button>
                        </form>
                    </div>

                    <!-- Recent Events Widget -->
                    <div class="bg-slate-50 p-6 border border-slate-200 shadow-sm">
                        <h4 class="text-sm font-serif font-bold text-primary border-b border-slate-200 pb-2 mb-4">
                            Recent Events
                        </h4>
                        
                        <div class="space-y-4">
                            @forelse($recentEvents as $recent)
                                <a href="{{ route('events.show', $recent) }}" class="flex gap-3 group items-center">
                                    <div class="w-16 h-12 overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
                                        @if($recent->thumbnail)
                                            <img src="{{ asset($recent->thumbnail) }}" alt="{{ $recent->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-all">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300 text-xs">
                                                <i class="ph ph-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h5 class="text-xs font-bold text-primary group-hover:text-secondary transition-colors line-clamp-2 leading-snug">
                                            {{ $recent->title }}
                                        </h5>
                                        <span class="text-[9px] text-slate-400 font-semibold block mt-0.5">
                                            {{ $recent->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </a>
                            @empty
                                <p class="text-slate-400 text-xs text-center py-4">No recent events found.</p>
                            @endforelse
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>
</x-home-layout>
