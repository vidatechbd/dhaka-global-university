<x-home-layout>
    <!-- Back to notices / Breadcrumb -->
    <div class="bg-slate-100 border-b border-slate-200 py-4 no-print">
        <div class="container mx-auto px-4 md:px-6 flex items-center justify-between text-xs text-slate-500 font-semibold">
            <div class="flex items-center gap-2">
                <a href="/" class="hover:text-primary transition">Home</a>
                <span>/</span>
                <a href="{{ route('notices.index') }}" class="hover:text-primary transition">Notices</a>
                <span>/</span>
                <span class="text-slate-700 truncate max-w-xs">{{ $notice->title }}</span>
            </div>
            <a href="{{ route('notices.index') }}" class="hover:text-primary transition flex items-center gap-1 font-bold text-primary">
                &larr; Back to Notices
            </a>
        </div>
    </div>

    <!-- Notice detail content -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Main Notice Area -->
                <article class="lg:col-span-8 space-y-6">
                    <header class="space-y-4">
                        <span class="inline-block bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded">
                            {{ $notice->created_at->format('F d, Y') }}
                        </span>
                        
                        <h1 class="text-2xl md:text-4xl font-serif font-bold text-primary leading-tight">
                            {{ $notice->title }}
                        </h1>
                        
                        <div class="flex items-center gap-4 text-xs text-slate-400 border-b border-slate-100 pb-4 font-semibold">
                            <span class="flex items-center gap-1">
                                <i class="ph ph-user"></i> Posted by Administration
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="ph ph-calendar"></i> {{ $notice->created_at->format('h:i A') }}
                            </span>
                        </div>
                    </header>

                    <div class="text-slate-700 leading-relaxed text-sm md:text-base space-y-4 font-normal news-body-content">
                        {!! nl2br(e($notice->content)) !!}
                    </div>

                    @if($notice->file_path)
                        <div class="mt-8 p-6 bg-slate-50 border border-slate-200 rounded-lg flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h4 class="font-bold text-primary text-sm">Attachment File Available</h4>
                                <p class="text-xs text-slate-500 mt-1">Download official document copy regarding this notice.</p>
                            </div>
                            <a href="{{ asset($notice->file_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold text-xs uppercase tracking-wider px-5 py-2.5 shadow transition shrink-0">
                                <i class="ph-bold ph-file-pdf text-base"></i> Download / View File
                            </a>
                        </div>
                    @endif
                </article>

                <!-- Sidebar Area -->
                <aside class="lg:col-span-4 space-y-8 no-print">
                    <!-- Search Widget -->
                    <div class="bg-slate-50 p-6 border border-slate-200 shadow-sm">
                        <h4 class="text-sm font-serif font-bold text-primary border-b border-slate-200 pb-2 mb-4">
                            Search Notices
                        </h4>
                        <form action="{{ route('notices.index') }}" method="GET" class="flex gap-2">
                            <input type="text" name="q" class="w-full border border-slate-300 text-xs px-3 py-2 outline-none focus:border-secondary text-slate-700 bg-white" placeholder="Search notices...">
                            <button type="submit" class="bg-primary hover:bg-secondary text-white px-4 py-2 font-bold text-xs uppercase transition shrink-0">
                                Search
                            </button>
                        </form>
                    </div>

                    <!-- Recent Notices Widget -->
                    <div class="bg-slate-50 p-6 border border-slate-200 shadow-sm">
                        <h4 class="text-sm font-serif font-bold text-primary border-b border-slate-200 pb-2 mb-4">
                            Recent Notices
                        </h4>
                        
                        <div class="space-y-4">
                            @forelse($recentNotices as $recent)
                                <a href="{{ route('notices.show', $recent) }}" class="block group">
                                    <h5 class="text-xs font-bold text-primary group-hover:text-secondary transition-colors line-clamp-2 leading-snug">
                                        {{ $recent->title }}
                                    </h5>
                                    <span class="text-[9px] text-slate-400 font-semibold block mt-0.5">
                                        {{ $recent->created_at->format('M d, Y') }}
                                    </span>
                                </a>
                            @empty
                                <p class="text-slate-400 text-xs text-center py-4">No recent notices.</p>
                            @endforelse
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-home-layout>
