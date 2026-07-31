@php
    $isCreateAction = request()->query('action') === 'create';
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Student Management') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Review admission applications and manage student accounts.</p>
            </div>
            <x-admin.btn href="{{ route('admin.students.index') }}?action=create" variant="primary" size="md">
                <i class="ph-bold ph-plus text-sm"></i>
                Create Student
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
            <!-- Create Student Form -->
            <x-admin.card title="Create Student Account" subtitle="Register a new student login for the portal." icon="ph-bold ph-user-plus" class="max-w-2xl mx-auto w-full">
                <form method="POST" action="{{ route('admin.students.store') }}" class="flex flex-col gap-5">
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
                        <x-admin.btn href="{{ route('admin.students.index') }}" variant="outline">Cancel</x-admin.btn>
                        <x-admin.btn type="submit" variant="primary">
                            <i class="ph-bold ph-check text-sm"></i>
                            Create Account
                        </x-admin.btn>
                    </div>
                </form>
            </x-admin.card>
        @else
            <!-- Pending Students List -->
            <x-admin.card title="Pending Approvals" subtitle="Admission applications waiting for review." icon="ph-bold ph-hourglass-medium">
                <x-slot name="actions">
                    <x-admin.badge color="amber">{{ $pendingStudents->count() }} pending</x-admin.badge>
                </x-slot>
                <div class="overflow-x-auto -mx-6">
                    <table class="w-full text-left admin-table">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-[10px] font-bold uppercase tracking-wider">
                                <th class="px-6 py-4">{{ __('Student') }}</th>
                                <th class="px-6 py-4">{{ __('Program & Type') }}</th>
                                <th class="px-6 py-4">{{ __('Academic Records') }}</th>
                                <th class="px-6 py-4 text-right">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                            @forelse($pendingStudents as $student)
                                <tr class="hover:bg-slate-50/60 transition align-top">
                                    <td class="px-6 py-4" data-label="Student">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-[#e0edf7] text-primary flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                                {{ substr($student->name, 0, 1) }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="font-bold text-slate-900 truncate">{{ $student->name }}</div>
                                                <div class="text-slate-500 truncate">{{ $student->email }}</div>
                                                <div class="text-slate-400">{{ $student->mobile }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4" data-label="Program & Type">
                                        <div class="font-semibold text-slate-800">{{ $student->program_type }}</div>
                                        <div class="text-slate-400 italic">{{ $student->admission_type }}</div>
                                    </td>
                                    <td class="px-6 py-4" data-label="Academic Records">
                                        <div class="space-y-0.5 text-slate-500">
                                            <div><span class="font-medium text-slate-600">SSC:</span> {{ $student->ssc_or_equivalent }} ({{ $student->ssc_division_or_gpa }})</div>
                                            <div><span class="font-medium text-slate-600">HSC:</span> {{ $student->hsc_or_equivalent }} ({{ $student->hsc_division_or_gpa }})</div>
                                            @if($student->bachelor_or_degree_hons)
                                                <div><span class="font-medium text-slate-600">Bach:</span> {{ $student->bachelor_or_degree_hons }} ({{ $student->bachelor_division_or_gpa }})</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap" data-label="Action">
                                        <div class="inline-flex items-center gap-1.5 justify-end">
                                            <form method="POST" action="{{ route('admin.students.approve', $student->id) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <x-admin.btn type="submit" variant="primary" size="sm">
                                                    <i class="ph-bold ph-check text-xs"></i>
                                                    Approve
                                                </x-admin.btn>
                                            </form>
                                            <form method="POST" action="{{ route('admin.students.reject', $student->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to reject this student?');">
                                                @csrf
                                                @method('DELETE')
                                                <x-admin.btn type="submit" variant="danger-soft" size="sm">
                                                    <i class="ph-bold ph-x text-xs"></i>
                                                    Reject
                                                </x-admin.btn>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" data-label="" class="px-6 py-14 text-center">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                                                <i class="ph-bold ph-hourglass-medium text-2xl"></i>
                                            </div>
                                            <span class="text-sm font-medium text-slate-500">{{ __('No pending approvals.') }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-admin.card>

            <!-- Active Students List -->
            <x-admin.card title="Active Students" subtitle="Approved students with portal access." icon="ph-bold ph-users-three">
                <x-slot name="actions">
                    <x-admin.badge color="green">{{ $activeStudents->count() }} active</x-admin.badge>
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
                            @forelse($activeStudents as $student)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4 font-bold text-slate-900" data-label="Name">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs uppercase">
                                                {{ substr($student->name, 0, 1) }}
                                            </div>
                                            {{ $student->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-slate-500" data-label="Email">{{ $student->email }}</td>
                                    <td class="px-6 py-4 text-right" data-label="Action">
                                        <form method="POST" action="{{ route('admin.students.destroy', $student) }}" onsubmit="return confirm('Are you sure you want to delete this student?');">
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
                                                <i class="ph-bold ph-users-three text-2xl"></i>
                                            </div>
                                            <span class="text-sm font-medium text-slate-500">{{ __('No active students.') }}</span>
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
