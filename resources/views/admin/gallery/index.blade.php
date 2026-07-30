<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">{{ __('Campus Gallery') }}</h1>
            <a href="{{ route('admin.gallery.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow transition-colors">
                + Add Image
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-700">{{ __('Gallery Images') }}</h2>
        </div>

        @if(session('success'))
            <div class="m-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-xs font-medium rounded-r-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($galleryItems as $item)
                    <div class="border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow transition bg-white flex flex-col justify-between">
                        <div>
                            <div class="h-44 relative bg-slate-950 flex items-center justify-center overflow-hidden group">
                                <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <span class="absolute top-2.5 left-2.5 px-2 py-0.5 bg-primary-300 text-white font-bold text-[9px] uppercase tracking-wider rounded">
                                    {{ $item->category }}
                                </span>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 text-xs line-clamp-2" title="{{ $item->title }}">
                                    {{ $item->title }}
                                </h3>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-[9px] text-gray-400">{{ $item->created_at->format('M d, Y') }}</span>
                                    @if($item->status === 'published')
                                        <span class="inline-block px-1.5 py-0.5 bg-green-50 text-green-700 text-[8px] font-bold rounded uppercase">Pub</span>
                                    @else
                                        <span class="inline-block px-1.5 py-0.5 bg-amber-50 text-amber-600 text-[8px] font-bold rounded uppercase">Draft</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-4 pb-4 pt-2 border-t border-gray-50 flex items-center justify-end gap-2">
                            <a href="{{ route('admin.gallery.edit', $item) }}" class="px-2 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold rounded text-[10px] transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this gallery item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded text-[10px] transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-gray-400 text-xs font-medium">
                        {{ __('No gallery items found.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>
