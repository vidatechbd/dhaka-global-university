<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">{{ __('Pages') }}</h1>
                <p class="text-xs text-gray-500 mt-1">Manage all custom static pages of your university portal.</p>
            </div>
            <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-md shadow-sm transition-all duration-200 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('Create Page') }}
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm border border-gray-300 overflow-hidden">
        <div class="p-4 border-b border-gray-300 flex items-center justify-between bg-gray-50">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                <h2 class="text-sm font-bold text-gray-700">{{ __('All Portal Pages') }}</h2>
            </div>
            <span class="text-xs font-semibold text-gray-600 bg-gray-200 border border-gray-300 px-2.5 py-0.5 rounded-md">{{ $pages->total() }} {{ Str::plural('page', $pages->total()) }}</span>
        </div>

        @if(session('success'))
            <div class="m-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-xs font-medium rounded-r-md flex items-center gap-2 border border-gray-300 border-l-0">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-300 text-gray-700 text-[10px] uppercase font-bold tracking-wider">
                        <th class="px-6 py-3 border-r border-gray-300 last:border-r-0">{{ __('Title') }}</th>
                        <th class="px-6 py-3 border-r border-gray-300 last:border-r-0">{{ __('Slug') }}</th>
                        <th class="px-6 py-3 border-r border-gray-300 last:border-r-0">{{ __('Created At') }}</th>
                        <th class="px-6 py-3 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 text-xs text-gray-600">
                    @forelse($pages as $page)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-800 border-r border-gray-300 last:border-r-0">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-md bg-blue-50 text-blue-700 border border-blue-300 flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ Str::upper(Str::substr($page->title, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="block hover:text-blue-700 cursor-pointer">{{ $page->title }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 border-r border-gray-300 last:border-r-0">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-mono font-medium bg-gray-100 text-gray-700 border border-gray-300">
                                    {{ $page->slug }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 border-r border-gray-300 last:border-r-0">
                                {{ $page->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-gray-300 bg-amber-50 hover:bg-amber-100 text-amber-700 transition-colors" title="Edit Page">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this page?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-gray-300 bg-rose-50 hover:bg-rose-100 text-rose-600 transition-colors" title="Delete Page">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="font-medium text-gray-600">{{ __('No pages found.') }}</span>
                                    <a href="{{ route('admin.pages.create') }}" class="text-xs text-blue-600 font-semibold hover:underline mt-1">Create your first page</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pages->hasPages())
            <div class="p-4 border-t border-gray-300 bg-gray-50">
                {{ $pages->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
