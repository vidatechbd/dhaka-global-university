<x-home-layout>
    <!-- Page Header Banner -->
    <section class="bg-primary text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-primaryDark/50 mix-blend-multiply z-0"></div>
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <span class="inline-block text-secondary font-bold uppercase tracking-widest text-xs mb-3">
                @if($page->parent)
                    {{ $page->parent->title }}
                @else
                    Dhaka Global University
                @endif
            </span>
            <h1 class="text-3xl md:text-5xl font-serif font-bold mb-4">
                {{ $page->title }}
            </h1>
        </div>
    </section>

    <!-- Page Body -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <!-- Main Content Area -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="text-slate-700 leading-relaxed text-sm md:text-base space-y-4 font-normal page-body-content">
                        {!! $page->content !!}
                    </div>
                </div>

                <!-- Sub-pages Navigation Sidebar -->
                <aside class="lg:col-span-4 space-y-8 no-print">
                    @php
                        // Get sibling/sub pages to display in sidebar
                        $parentPage = $page->parent ?: $page;
                        $relatedPages = \App\Models\Page::where('parent_id', $parentPage->id)
                            ->orWhere('id', $parentPage->id)
                            ->orderBy('sort_order')
                            ->orderBy('title')
                            ->get();
                    @endphp

                    @if($relatedPages->count() > 1)
                        <div class="bg-slate-50 p-6 border border-slate-200 shadow-sm">
                            <h4 class="text-sm font-serif font-bold text-primary border-b border-slate-200 pb-2 mb-4">
                                {{ $parentPage->title }} Sections
                            </h4>
                            <ul class="space-y-2.5">
                                @foreach($relatedPages as $relPage)
                                    <li>
                                        <a href="{{ route('page.show', $relPage->slug) }}" class="block text-xs font-semibold py-1.5 px-3 border-l-2 transition-all {{ $page->id === $relPage->id ? 'border-secondary text-secondary bg-white shadow-sm' : 'border-transparent text-slate-600 hover:border-slate-300 hover:text-primary' }}">
                                            {{ $relPage->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Help contact widget -->
                    <div class="bg-primary text-white p-6 border border-primaryDark shadow-sm relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 opacity-10">
                            <i class="ph ph-graduation-cap text-9xl"></i>
                        </div>
                        <h4 class="text-sm font-serif font-bold border-b border-white/20 pb-2 mb-4 relative z-10">
                            Need Assistance?
                        </h4>
                        <p class="text-white/80 text-xs mb-4 relative z-10 leading-relaxed">
                            For support or academic requests, please contact our registrar's office during office hours.
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
