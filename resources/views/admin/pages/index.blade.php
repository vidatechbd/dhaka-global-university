<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Pages') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Manage all custom static pages of your university portal.</p>
            </div>
            <x-admin.btn href="{{ route('admin.pages.create') }}" variant="primary" size="md">
                <i class="ph-bold ph-plus text-sm"></i>
                Create Page
            </x-admin.btn>
        </div>
    </x-slot>

    <x-admin.card title="All Portal Pages" subtitle="Static pages displayed under the main navigation." icon="ph-bold ph-file-text">
        <x-slot name="actions">
            <x-admin.badge color="navy">{{ $pages->total() }} {{ Str::plural('page', $pages->total()) }}</x-admin.badge>
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
                        <th class="px-6 py-4">{{ __('Title') }}</th>
                        <th class="px-6 py-4">{{ __('Parent Page') }}</th>
                        <th class="px-6 py-4">{{ __('Slug') }}</th>
                        <th class="px-6 py-4 text-center">{{ __('Sort Order') }}</th>
                        <th class="px-6 py-4">{{ __('Created At') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($pages as $page)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4 font-semibold text-slate-800" data-label="Title">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-[#e0edf7] text-primary border border-[#0a3a60]/10 flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ Str::upper(Str::substr($page->title, 0, 1)) }}
                                    </div>
                                    <span>{{ $page->title }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Parent Page">
                                @if($page->parent)
                                    <x-admin.badge color="navy">{{ $page->parent->title }}</x-admin.badge>
                                @else
                                    <span class="text-slate-400 italic">None (Top Level)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4" data-label="Slug">
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-mono font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    /{{ $page->slug }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-mono font-semibold text-slate-700 text-center" data-label="Sort Order">
                                {{ $page->sort_order }}
                            </td>
                            <td class="px-6 py-4 text-slate-500" data-label="Created At">
                                {{ $page->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap" data-label="">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 bg-amber-50 hover:bg-amber-100 text-amber-700 transition-colors" title="Edit Page">
                                        <i class="ph-bold ph-pencil-simple text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this page?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 bg-rose-50 hover:bg-rose-100 text-rose-600 transition-colors" title="Delete Page">
                                            <i class="ph-bold ph-trash text-sm"></i>
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
                                        <i class="ph-bold ph-file-text text-2xl"></i>
                                    </div>
                                    <span class="text-sm font-medium text-slate-500">{{ __('No pages found.') }}</span>
                                    <x-admin.btn href="{{ route('admin.pages.create') }}" variant="primary" size="sm" class="mt-1">
                                        Create your first page
                                    </x-admin.btn>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pages->hasPages())
            <div class="p-6 border-t border-slate-100">
                {{ $pages->links() }}
            </div>
        @endif
    </x-admin.card>
</x-admin-layout>
