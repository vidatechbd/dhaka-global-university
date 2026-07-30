<x-home-layout>
    <x-slot name="header">
        <div class="bg-primary py-12 text-center text-white">
            <h1 class="text-3xl md:text-5xl font-serif font-bold">Notice Board</h1>
            <p class="text-xs text-slate-300 mt-2 uppercase tracking-widest font-bold">Important announcements and academic notices</p>
        </div>
    </x-slot>

    <!-- Notices Listing Section -->
    <section class="py-16 bg-slate-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Main Notices List -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-primary">Academic Notices</h2>
                        <span class="text-xs text-slate-500 font-semibold">{{ $notices->total() }} notices found</span>
                    </div>

                    @forelse($notices as $notice)
                        <div class="bg-white border border-slate-200 p-6 shadow-sm hover:shadow-md transition group relative">
                            <div class="text-xs font-bold text-secondary mb-2 flex items-center gap-1.5">
                                <i class="ph-bold ph-calendar-blank"></i> 
                                {{ $notice->created_at->format('F d, Y') }}
                            </div>
                            <h3 class="text-xl font-serif font-bold text-primary group-hover:text-secondary transition-colors mb-3">
                                <a href="{{ route('notices.show', $notice) }}">{{ $notice->title }}</a>
                            </h3>
                            <p class="text-slate-600 text-sm line-clamp-3 mb-4">
                                {{ strip_tags($notice->content) }}
                            </p>
                            
                            <div class="flex items-center justify-between border-t border-slate-100 pt-4">
                                <a href="{{ route('notices.show', $notice) }}" class="text-xs font-bold text-primary group-hover:text-secondary transition flex items-center gap-1 uppercase tracking-wider">
                                    Read Details &rarr;
                                </a>
                                
                                @if($notice->file_path)
                                    <a href="{{ asset($notice->file_path) }}" target="_blank" class="inline-flex items-center gap-1 bg-red-50 text-red-700 hover:bg-red-100 font-bold text-[10px] uppercase tracking-wider px-3 py-1 rounded transition border border-red-200">
                                        <i class="ph-bold ph-file-pdf"></i> Download PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border border-slate-200 p-12 text-center text-slate-400 font-medium">
                            No notices available.
                        </div>
                    @endforelse

                    <div class="mt-8">
                        {{ $notices->links() }}
                    </div>
                </div>

                <!-- Sidebar Area -->
                <aside class="lg:col-span-4 space-y-8">
                    <!-- Search Widget -->
                    <div class="bg-white p-6 border border-slate-200 shadow-sm">
                        <h4 class="text-sm font-serif font-bold text-primary border-b border-slate-200 pb-2 mb-4">
                            Search Notices
                        </h4>
                        <form action="{{ route('notices.index') }}" method="GET" class="flex gap-2">
                            <input type="text" name="q" value="{{ request('q') }}" class="w-full border border-slate-300 text-xs px-3 py-2 outline-none focus:border-secondary text-slate-700 bg-white" placeholder="Search notices...">
                            <button type="submit" class="bg-primary hover:bg-secondary text-white px-4 py-2 font-bold text-xs uppercase transition shrink-0">
                                Search
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-home-layout>
