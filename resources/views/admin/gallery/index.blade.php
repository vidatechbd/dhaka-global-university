<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Campus Gallery') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Showcase photos from campus life.</p>
            </div>
            <x-admin.btn href="{{ route('admin.gallery.create') }}" variant="primary" size="md">
                <i class="ph-bold ph-plus text-sm"></i>
                Add Image
            </x-admin.btn>
        </div>
    </x-slot>

    <x-admin.card title="Gallery Images" subtitle="Manage the images shown in the campus visual tour." icon="ph-bold ph-images">
        <x-slot name="actions">
            <x-admin.badge color="navy">{{ $galleryItems->count() }} {{ Str::plural('image', $galleryItems->count()) }}</x-admin.badge>
        </x-slot>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-xs font-medium rounded-r-lg flex items-center gap-2">
                <i class="ph-bold ph-check-circle text-base"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @forelse($galleryItems as $item)
                <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition bg-white flex flex-col">
                    <div class="h-44 relative bg-slate-950 flex items-center justify-center overflow-hidden group">
                        <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-3 left-3 px-2.5 py-1 bg-primary text-white font-bold text-[9px] uppercase tracking-wider rounded-full shadow">
                            {{ $item->category }}
                        </span>
                        <span class="absolute top-3 right-3">
                            @if($item->status === 'published')
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-500 text-white text-[9px] font-bold rounded-full shadow">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span> Published
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-500 text-white text-[9px] font-bold rounded-full shadow">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span> Draft
                                </span>
                            @endif
                        </span>
                    </div>
                    <div class="p-4 flex-1">
                        <h3 class="font-bold text-slate-800 text-xs line-clamp-2" title="{{ $item->title }}">
                            {{ $item->title }}
                        </h3>
                        <div class="mt-2 flex items-center gap-1.5 text-[10px] text-slate-400">
                            <i class="ph-bold ph-calendar-blank"></i>
                            {{ $item->created_at->format('M d, Y') }}
                        </div>
                    </div>

                    <div class="px-4 pb-4 pt-2 border-t border-slate-100 flex items-center justify-between gap-2">
                        <a href="{{ asset($item->image_path) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-[#e0edf7] hover:bg-[#d0e2f2] text-primary font-bold rounded-lg text-[10px] transition">
                            <i class="ph-bold ph-eye text-xs"></i>
                            View
                        </a>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('admin.gallery.edit', $item) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold rounded-lg text-[10px] transition">
                                <i class="ph-bold ph-pencil-simple text-xs"></i>
                                Edit
                            </a>
                            <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this gallery item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded-lg text-[10px] transition">
                                    <i class="ph-bold ph-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center flex flex-col items-center gap-2">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                        <i class="ph-bold ph-images text-2xl"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-500">{{ __('No gallery items found.') }}</span>
                    <x-admin.btn href="{{ route('admin.gallery.create') }}" variant="primary" size="sm" class="mt-1">
                        Upload your first image
                    </x-admin.btn>
                </div>
            @endforelse
        </div>
    </x-admin.card>
</x-admin-layout>
