@php
    $isCreateAction = request()->query('action') === 'create';
@endphp

<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Management') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col gap-6">

                @if(session('success'))
                    <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-xs font-medium rounded-r-lg shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($isCreateAction)
                    <!-- Create Teacher Form (Full Width) -->
                    <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-8 max-w-2xl mx-auto w-full">
                        <div class="flex items-center gap-3 mb-6">
                            <a href="{{ route('admin.teachers.index') }}" class="text-gray-500 hover:text-gray-800">
                                &larr; Back
                            </a>
                            <h3 class="text-xl font-bold text-gray-800">{{ __('Create Teacher Account') }}</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.teachers.store') }}" class="flex flex-col gap-5">
                            @csrf
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm" required />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm" required />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>
                            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                                <a href="{{ route('admin.teachers.index') }}" class="px-4 py-2 border border-gray-200 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-50 transition">
                                    Cancel
                                </a>
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow transition">
                                    {{ __('Create Account') }}
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <!-- Teachers List Card (Full Width) -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm w-full">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-800">{{ __('Teachers List') }}</h3>
                            <a href="{{ route('admin.teachers.index') }}?action=create" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow transition-colors">
                                + Create Teacher
                            </a>
                        </div>
                        <div class="overflow-x-auto border border-gray-100 rounded-xl">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-gray-200 text-slate-600 text-xs font-bold uppercase tracking-wider">
                                        <th class="px-6 py-4">{{ __('Name') }}</th>
                                        <th class="px-6 py-4">{{ __('Email') }}</th>
                                        <th class="px-6 py-4 text-right">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-xs text-slate-700">
                                    @forelse($teachers as $teacher)
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <td class="px-6 py-4 font-bold text-slate-900">{{ $teacher->name }}</td>
                                            <td class="px-6 py-4 font-medium text-slate-500">{{ $teacher->email }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded transition">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center text-gray-400 font-medium">
                                                {{ __('No teachers added yet.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-admin-layout>
