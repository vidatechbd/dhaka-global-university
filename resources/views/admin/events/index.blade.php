<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Campus Events') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Organize and manage university events.</p>
            </div>
            <x-admin.btn href="{{ route('admin.events.create') }}" variant="primary" size="md">
                <i class="ph-bold ph-plus text-sm"></i>
                Create Event
            </x-admin.btn>
        </div>
    </x-slot>

    <x-admin.card title="All Events" subtitle="Every event displayed on the campus events calendar." icon="ph-bold ph-calendar-dots">
        <x-slot name="actions">
            <x-admin.badge color="navy">{{ $events->count() }} {{ Str::plural('event', $events->count()) }}</x-admin.badge>
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
                        <th class="px-6 py-4">{{ __('Created At') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($events as $event)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4 text-center" data-label="Thumbnail">
                                @if($event->thumbnail)
                                    <img src="{{ asset($event->thumbnail) }}" alt="Thumbnail" class="w-12 h-8 object-cover rounded-lg border border-slate-100 mx-auto">
                                @else
                                    <div class="w-12 h-8 bg-slate-100 text-slate-400 flex items-center justify-center rounded-lg text-[10px] mx-auto">
                                        No Img
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800" data-label="Title">
                                {{ $event->title }}
                            </td>
                            <td class="px-6 py-4" data-label="Author">
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="w-6 h-6 rounded-full bg-[#e0edf7] text-primary text-[9px] font-bold flex items-center justify-center uppercase">
                                        {{ substr($event->user->name ?? 'S', 0, 1) }}
                                    </span>
                                    {{ $event->user->name ?? 'System' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center" data-label="Status">
                                @if($event->status === 'published')
                                    <x-admin.badge color="green">Published</x-admin.badge>
                                @else
                                    <x-admin.badge color="amber">Draft</x-admin.badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500" data-label="Created At">
                                {{ $event->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap" data-label="">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <a href="{{ route('admin.events.edit', $event) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold rounded-lg transition">
                                        <i class="ph-bold ph-pencil-simple text-xs"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
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
                                        <i class="ph-bold ph-calendar-dots text-2xl"></i>
                                    </div>
                                    <span class="text-sm font-medium text-slate-500">{{ __('No events found.') }}</span>
                                    <x-admin.btn href="{{ route('admin.events.create') }}" variant="primary" size="sm" class="mt-1">
                                        Create your first event
                                    </x-admin.btn>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($events->hasPages())
            <div class="p-6 border-t border-slate-100">
                {{ $events->links() }}
            </div>
        @endif
    </x-admin.card>
</x-admin-layout>
