<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">{{ __('Campus Events') }}</h1>
            <a href="{{ route('admin.events.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow transition-colors">
                + Create Event
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-700">{{ __('All Events') }}</h2>
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
                        <th class="px-6 py-4 text-center" style="width: 80px;">{{ __('Thumbnail') }}</th>
                        <th class="px-6 py-4">{{ __('Title') }}</th>
                        <th class="px-6 py-4">{{ __('Author') }}</th>
                        <th class="px-6 py-4 text-center">{{ __('Status') }}</th>
                        <th class="px-6 py-4">{{ __('Created At') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs text-gray-600">
                    @forelse($events as $event)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 text-center">
                                @if($event->thumbnail)
                                    <img src="{{ asset($event->thumbnail) }}" alt="Thumbnail" class="w-12 h-8 object-cover rounded-md border border-gray-100 mx-auto">
                                @else
                                    <div class="w-12 h-8 bg-gray-100 text-gray-400 flex items-center justify-center rounded-md text-[10px] mx-auto">
                                        No Img
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $event->title }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $event->user->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($event->status === 'published')
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
                                {{ $event->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.events.edit', $event) }}" class="inline-block px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold rounded transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
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
                                {{ __('No events found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($events->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
