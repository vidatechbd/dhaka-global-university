@php
    $isCreateAction = request()->query('action') === 'create';
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Teacher Management') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Manage faculty accounts with portal access.</p>
            </div>
            <x-admin.btn href="{{ route('admin.teachers.index') }}?action=create" variant="primary" size="md">
                <i class="ph-bold ph-plus text-sm"></i>
                Create Teacher
            </x-admin.btn>
        </div>
    </x-slot>

    <div class="flex flex-col gap-6">

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-xs font-medium rounded-r-lg shadow-sm flex items-center gap-2">
                <i class="ph-bold ph-check-circle text-base"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($isCreateAction)
            <!-- Create Teacher Form -->
            <x-admin.card title="Create Teacher Account" subtitle="Register a new faculty login for the portal." icon="ph-bold ph-user-plus" class="max-w-2xl mx-auto w-full">
                <form method="POST" action="{{ route('admin.teachers.store') }}" class="flex flex-col gap-5">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" name="password" type="password" class="mt-1.5 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <x-admin.btn href="{{ route('admin.teachers.index') }}" variant="outline">Cancel</x-admin.btn>
                        <x-admin.btn type="submit" variant="primary">
                            <i class="ph-bold ph-check text-sm"></i>
                            Create Account
                        </x-admin.btn>
                    </div>
                </form>
            </x-admin.card>
        @else
            <!-- Teachers List Card -->
            <x-admin.card title="Teachers List" subtitle="All registered faculty members." icon="ph-bold ph-graduation-cap">
                <x-slot name="actions">
                    <x-admin.badge color="navy">{{ $teachers->count() }} {{ Str::plural('teacher', $teachers->count()) }}</x-admin.badge>
                </x-slot>
                <div class="overflow-x-auto -mx-6">
                    <table class="w-full text-left admin-table">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-[10px] font-bold uppercase tracking-wider">
                                <th class="px-6 py-4">{{ __('Name') }}</th>
                                <th class="px-6 py-4">{{ __('Email') }}</th>
                                <th class="px-6 py-4 text-right">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                            @forelse($teachers as $teacher)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4 font-bold text-slate-900" data-label="Name">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#e0edf7] text-primary flex items-center justify-center font-bold text-xs uppercase">
                                                {{ substr($teacher->name, 0, 1) }}
                                            </div>
                                            {{ $teacher->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-slate-500" data-label="Email">{{ $teacher->email }}</td>
                                    <td class="px-6 py-4 text-right" data-label="Action">
                                        <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" onsubmit="return confirm('Are you sure you want to delete this teacher?');">
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
                                                <i class="ph-bold ph-graduation-cap text-2xl"></i>
                                            </div>
                                            <span class="text-sm font-medium text-slate-500">{{ __('No teachers added yet.') }}</span>
                                            <x-admin.btn href="{{ route('admin.teachers.index') }}?action=create" variant="primary" size="sm" class="mt-1">
                                                Add your first teacher
                                            </x-admin.btn>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-admin.card>
        @endif

    </div>
</x-admin-layout>
