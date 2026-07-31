<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Role Management') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Define roles and control access to the admin panel.</p>
            </div>
            <x-admin.btn href="{{ route('admin.roles.create') }}" variant="primary" size="md">
                <i class="ph-bold ph-plus text-sm"></i>
                Add New Role
            </x-admin.btn>
        </div>
    </x-slot>

    <x-admin.card title="Roles List" subtitle="Each role bundles a set of access permissions." icon="ph-bold ph-shield-check">
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-xs font-medium rounded-r-lg flex items-center gap-2">
                <i class="ph-bold ph-check-circle text-base"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 text-xs font-medium rounded-r-lg flex items-center gap-2">
                <i class="ph-bold ph-warning-circle text-base"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto -mx-6">
            <table class="w-full text-left admin-table">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider">
                        <th class="px-6 py-4">{{ __('Role Name') }}</th>
                        <th class="px-6 py-4">{{ __('Permissions') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                    @forelse($roles as $role)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4 whitespace-nowrap" data-label="Role Name">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($role->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-800">{{ $role->name }}</span>
                                    @if($role->name === 'Principal')
                                        <x-admin.badge color="orange">Super Admin</x-admin.badge>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4" data-label="Permissions">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($role->permissions as $perm)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#e0edf7] text-primary">
                                            {{ $perm->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400 italic">No permissions mapped</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right" data-label="">
                                <div class="flex justify-end gap-2">
                                    <x-admin.btn href="{{ route('admin.roles.edit', $role) }}" variant="amber-soft" size="sm">
                                        <i class="ph-bold ph-pencil-simple text-xs"></i>
                                        Edit
                                    </x-admin.btn>
                                    @if($role->name !== 'Principal')
                                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-admin.btn type="submit" variant="danger-soft" size="sm">
                                                <i class="ph-bold ph-trash text-xs"></i>
                                                Delete
                                            </x-admin.btn>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" data-label="" class="px-6 py-14 text-center">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                                        <i class="ph-bold ph-shield-check text-2xl"></i>
                                    </div>
                                    <span class="text-sm font-medium text-slate-500">{{ __('No roles defined.') }}</span>
                                    <x-admin.btn href="{{ route('admin.roles.create') }}" variant="primary" size="sm" class="mt-1">
                                        Create your first role
                                    </x-admin.btn>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-admin.card>
</x-admin-layout>
