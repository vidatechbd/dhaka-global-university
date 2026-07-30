<x-home-layout>
    <!-- Header Banner -->
    <section class="bg-primary text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-primaryDark/50 mix-blend-multiply z-0"></div>
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="max-w-2xl">
                <span class="inline-block text-secondary font-bold uppercase tracking-widest text-xs mb-3">
                    Dhaka Global University
                </span>
                <h1 class="text-3xl md:text-5xl font-serif font-bold mb-4">
                    @if(request('q'))
                        Search Events for "{{ request('q') }}"
                    @else
                        Campus Events
                    @endif
                </h1>
                <p class="text-white/80 text-sm md:text-base leading-relaxed">
                    Explore upcoming seminars, symposiums, academic festivals, and community programs happening at our university.
                </p>
            </div>
        </div>
    </section>

    <!-- Search & Grid Section -->
    <section class="py-16 bg-slate-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <!-- Main Grid List -->
                <div class="lg:col-span-9 space-y-8">
                    @if($events->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($events as $eventItem)
                                <div class="bg-white border border-slate-200 shadow-sm hover:shadow-md transition group overflow-hidden flex flex-col">
                                    <div class="h-56 relative overflow-hidden bg-slate-100 shrink-0">
                                        @if($eventItem->thumbnail)
                                            <img src="{{ asset($eventItem->thumbnail) }}" alt="{{ $eventItem->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i class="ph-bold ph-calendar text-5xl"></i>
                                            </div>
                                        @endif
                                        <div class="absolute top-4 left-4 bg-secondary text-white px-3 py-1 text-center shadow-md z-10">
                                            <div class="font-bold text-lg leading-none">{{ $eventItem->event_date ? $eventItem->event_date->format('d') : $eventItem->created_at->format('d') }}</div>
                                            <div class="text-[10px] font-bold uppercase mt-0.5">{{ $eventItem->event_date ? $eventItem->event_date->format('M') : $eventItem->created_at->format('M') }}</div>
                                        </div>
                                        <div class="absolute top-4 right-4 z-10">
                                            @if($eventItem->event_date)
                                                @if($eventItem->event_date->isFuture() || $eventItem->event_date->isToday())
                                                    <span class="bg-green-600 text-white font-bold text-[9px] uppercase tracking-wider px-2 py-0.5 rounded shadow">Upcoming</span>
                                                @else
                                                    <span class="bg-slate-500 text-white font-bold text-[9px] uppercase tracking-wider px-2 py-0.5 rounded shadow">Completed</span>
                                                @endif
                                            @else
                                                <span class="bg-green-600 text-white font-bold text-[9px] uppercase tracking-wider px-2 py-0.5 rounded shadow">Upcoming</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="p-6 flex-grow flex flex-col justify-between">
                                        <div>
                                            <span class="text-secondary text-xs font-bold uppercase tracking-widest mb-2 block">
                                                {{ $eventItem->created_at->format('F d, Y') }}
                                            </span>
                                            <h3 class="text-lg font-serif font-bold text-primary mb-3 group-hover:text-secondary transition-colors line-clamp-2">
                                                {{ $eventItem->title }}
                                            </h3>
                                            <p class="text-slate-600 text-xs leading-relaxed mb-4 line-clamp-3">
                                                {{ strip_tags($eventItem->content) }}
                                            </p>
                                        </div>
                                        <a href="{{ route('events.show', $eventItem) }}" class="text-primary font-bold text-xs flex items-center gap-1 group-hover:text-secondary transition w-max">
                                            View Event Details &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination Links -->
                        <div class="pt-6 border-t border-slate-200">
                            {{ $events->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="bg-white border border-slate-200 p-12 text-center rounded-none text-slate-400">
                            <i class="ph ph-calendar text-5xl text-slate-300 mb-3 block mx-auto"></i>
                            <p class="text-sm font-semibold">No events found matching your query.</p>
                            <a href="{{ route('events.index') }}" class="text-xs text-blue-600 font-bold hover:underline mt-2 inline-block">Clear search filters</a>
                        </div>
                    @endif
                </div>

                <!-- Index Page Sidebar -->
                <aside class="lg:col-span-3 space-y-8">
                    <!-- Search Widget -->
                    <div class="bg-white p-6 border border-slate-200 shadow-sm">
                        <h4 class="text-sm font-serif font-bold text-primary border-b border-slate-200 pb-2 mb-4">
                            Search Events
                        </h4>
                        <form action="{{ route('events.index') }}" method="GET" class="flex gap-2">
                            <input type="text" name="q" value="{{ request('q') }}" class="w-full border border-slate-300 text-xs px-3 py-2 outline-none focus:border-secondary text-slate-700 bg-white" placeholder="Keyword...">
                            <button type="submit" class="bg-primary hover:bg-secondary text-white px-4 py-2 font-bold text-xs uppercase transition">
                                Go
                            </button>
                        </form>
                    </div>

                    <!-- Campus Contacts Widget -->
                    <div class="bg-primary text-white p-6 border border-primaryDark shadow-sm relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 opacity-10">
                            <i class="ph ph-graduation-cap text-9xl"></i>
                        </div>
                        <h4 class="text-sm font-serif font-bold border-b border-white/20 pb-2 mb-4 relative z-10">
                            Need Help?
                        </h4>
                        <p class="text-white/80 text-xs mb-4 relative z-10 leading-relaxed">
                            For admissions inquiries or academic questions, feel free to reach out to our administration office.
                        </p>
                        <a href="mailto:registrar@feniuniversity.ac.bd" class="text-secondary hover:text-white transition font-bold text-xs flex items-center gap-1 relative z-10">
                            Contact Registrar &rarr;
                        </a>
                    </div>
                </aside>

            </div>
        </div>
    </section>
</x-home-layout>
