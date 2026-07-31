<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('News Articles') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Manage the latest campus news articles.</p>
            </div>
            <x-admin.btn href="{{ route('admin.news.create') }}" variant="primary" size="md">
                <i class="ph-bold ph-plus text-sm"></i>
                Create News
            </x-admin.btn>
        </div>
    </x-slot>

    <x-admin.card title="All Articles" subtitle="Every news article posted on the university portal." icon="ph-bold ph-newspaper">
        <x-slot name="actions">
            <x-admin.badge color="navy">{{ $news->count() }} {{ Str::plural('article', $news->count()) }}</x-admin.badge>
        </x-slot>

        @if(session('success'))
            <div class="m-6 mb-0 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-xs font-medium rounded-r-lg flex items-center gap-2">
                <i class="ph-bold ph-check-circle text-base"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left admin-table">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider">
                        <th class="px-6 py-4 text-center" style="width: 80px;">{{ __('Thumbnail') }}</th>
                        <th class="px-6 py-4">{{ __('Title') }}</th>
                        <th class="px-6 py-4">{{ __('Author') }}</th>
                        <th class="px-6 py-4 text-center">{{ __('Status') }}</th>
                        <th class="px-6 py-4">{{ __('Published At') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($news as $article)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4 text-center" data-label="Thumbnail">
                                @if($article->thumbnail)
                                    <img src="{{ asset($article->thumbnail) }}" alt="Thumbnail" class="w-12 h-8 object-cover rounded-lg border border-slate-100 mx-auto">
                                @else
                                    <div class="w-12 h-8 bg-slate-100 text-slate-400 flex items-center justify-center rounded-lg text-[10px] mx-auto">
                                        No Img
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800" data-label="Title">
                                {{ $article->title }}
                            </td>
                            <td class="px-6 py-4" data-label="Author">
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="w-6 h-6 rounded-full bg-[#e0edf7] text-primary text-[9px] font-bold flex items-center justify-center uppercase">
                                        {{ substr($article->user->name ?? 'S', 0, 1) }}
                                    </span>
                                    {{ $article->user->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center" data-label="Status">
                                @if($article->status === 'published')
                                    <x-admin.badge color="green">Published</x-admin.badge>
                                @else
                                    <x-admin.badge color="amber">Draft</x-admin.badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500" data-label="Published At">
                                {{ $article->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap" data-label="">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <a href="{{ route('admin.news.edit', $article) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold rounded-lg transition">
                                        <i class="ph-bold ph-pencil-simple text-xs"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this news article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded-lg transition">
                                            <i class="ph-bold ph-trash text-xs"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" data-label="" class="px-6 py-14 text-center">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                                        <i class="ph-bold ph-newspaper text-2xl"></i>
                                    </div>
                                    <span class="text-sm font-medium text-slate-500">{{ __('No news articles found.') }}</span>
                                    <x-admin.btn href="{{ route('admin.news.create') }}" variant="primary" size="sm" class="mt-1">
                                        Create your first article
                                    </x-admin.btn>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($news->hasPages())
            <div class="p-6 border-t border-slate-100">
                {{ $news->links() }}
            </div>
        @endif
    </x-admin.card>
</x-admin-layout>
