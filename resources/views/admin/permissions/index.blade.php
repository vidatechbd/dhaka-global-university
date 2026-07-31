<x-admin-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-bold text-primary">{{ __('Permission Management') }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Create fine-grained access permissions for roles.</p>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-xs font-medium rounded-r-lg flex items-center gap-2">
            <i class="ph-bold ph-check-circle text-base"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Create Permission Card -->
        <x-admin.card title="Create New Permission" subtitle="Add a new action permission name." icon="ph-bold ph-plus-circle" class="h-fit">
            <form method="POST" action="{{ route('admin.permissions.store') }}" class="flex flex-col gap-4">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Permission Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full" required placeholder="e.g. edit articles" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-admin.btn type="submit" variant="primary" class="w-full">
                        <i class="ph-bold ph-check text-sm"></i>
                        Create Permission
                    </x-admin.btn>
                </div>
            </form>
        </x-admin.card>

        <!-- Permissions List Card -->
        <x-admin.card title="Available Permissions" subtitle="All permissions available across the portal." icon="ph-bold ph-list-checks" class="lg:col-span-2">
            <div class="overflow-x-auto -mx-6">
                <table class="w-full text-left admin-table">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider">
                            <th class="px-6 py-4">{{ __('Name') }}</th>
                            <th class="px-6 py-4">{{ __('Guard') }}</th>
                            <th class="px-6 py-4 text-right">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        @forelse($permissions as $permission)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-6 py-4 whitespace-nowrap" data-label="Name">
                                    <span class="inline-flex items-center gap-2 font-semibold text-slate-800">
                                        <i class="ph ph-key text-primary"></i>
                                        {{ $permission->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap" data-label="Guard">
                                    <x-admin.badge color="slate">{{ $permission->guard_name }}</x-admin.badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right" data-label="">
                                    <form method="POST" action="{{ route('admin.permissions.destroy', $permission) }}" onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-admin.btn type="submit" variant="danger-soft" size="sm">
                                            <i class="ph-bold ph-trash text-xs"></i>
                                            Delete
                                        </x-admin.btn>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" data-label="" class="px-6 py-14 text-center">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                                            <i class="ph-bold ph-list-checks text-2xl"></i>
                                        </div>
                                        <span class="text-sm font-medium text-slate-500">{{ __('No permissions created yet.') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-admin.card>
    </div>
</x-admin-layout>
