<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">{{ __('Notices Board') }}</h1>
            <a href="{{ route('admin.notices.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow transition-colors">
                + Create Notice
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-700">{{ __('All Notices') }}</h2>
        </div>

        @if(session('success'))
            <div class="m-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-xs font-medium rounded-r-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 text-[10px] uppercase font-bold tracking-wider">
                        <th class="px-6 py-4">{{ __('Title') }}</th>
                        <th class="px-6 py-4">{{ __('Author') }}</th>
                        <th class="px-6 py-4 text-center">{{ __('Attachment') }}</th>
                        <th class="px-6 py-4 text-center">{{ __('Status') }}</th>
                        <th class="px-6 py-4">{{ __('Date') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs text-gray-600">
                    @forelse($notices as $notice)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $notice->title }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $notice->user->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($notice->file_path)
                                    <a href="{{ asset($notice->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold">
                                        <i class="ph ph-file-pdf text-base"></i> View File
                                    </a>
                                @else
                                    <span class="text-gray-400">None</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($notice->status === 'published')
                                    <span class="inline-block px-2.5 py-1 bg-green-50 border border-green-200 text-green-700 font-bold text-[9px] rounded-md uppercase">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 bg-amber-50 border border-amber-200 text-amber-600 font-bold text-[9px] rounded-md uppercase">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $notice->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.notices.edit', $notice) }}" class="inline-block px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold rounded transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.notices.destroy', $notice) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this notice?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400 font-medium">
                                {{ __('No notices found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
