<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">{{ __('Sidebars Management') }}</h1>
            <a href="{{ route('admin.sidebars.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded shadow-sm transition">
                Create Sidebar
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-300 overflow-hidden">
        @if(session('success'))
            <div class="p-4 bg-green-50 border-b border-green-200 text-green-700 text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 font-bold uppercase tracking-wider">
                        <th class="px-6 py-3 font-semibold">Sidebar Name</th>
                        <th class="px-6 py-3 font-semibold text-center">Widgets/Content blocks</th>
                        <th class="px-6 py-3 font-semibold text-center">Linked Pages</th>
                        <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700">
                    @forelse($sidebars as $sidebar)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $sidebar->name }}</td>
                            <td class="px-6 py-4 text-center">{{ $sidebar->contents_count }}</td>
                            <td class="px-6 py-4 text-center">{{ $sidebar->pages_count }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.sidebars.edit', $sidebar) }}" class="text-blue-600 hover:text-blue-900 font-bold">Edit</a>
                                <form action="{{ route('admin.sidebars.destroy', $sidebar) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this sidebar? All associated pages will lose their sidebar link.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">No sidebars created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
