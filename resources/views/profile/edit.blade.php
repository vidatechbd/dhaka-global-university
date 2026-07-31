@php
    $layout = auth()->user()->hasRole('Student') ? 'app-layout' : 'admin-layout';
    $role = auth()->user()->roles->pluck('name')->first() ?? 'User';
@endphp

<x-dynamic-component :component="$layout">
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-[#0a3a60]">{{ __('My Profile') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Manage your account information, password and settings.</p>
            </div>
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">
                <i class="ph-bold ph-arrow-left"></i>
                Back
            </a>
        </div>
    </x-slot>

    <div class="space-y-6 max-w-5xl">
        <!-- Profile Hero -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="h-24 bg-gradient-to-r from-[#0a3a60] to-[#072740] relative">
                <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 50%, #f7941d 0, transparent 40%), radial-gradient(circle at 80% 20%, #f7941d 0, transparent 30%);"></div>
            </div>
            <div class="px-6 pb-6 -mt-10">
                <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                    <div class="w-20 h-20 rounded-2xl bg-secondary text-white flex items-center justify-center font-bold text-2xl uppercase shadow-lg shadow-secondary/30 border-4 border-white shrink-0">
                        {{ substr($user->name, 0, 2) }}
                    </div>
                    <div class="pb-1 min-w-0">
                        <h2 class="text-xl font-bold text-slate-800 truncate">{{ $user->name }}</h2>
                        <div class="flex flex-wrap items-center gap-2 mt-1.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-[#e0edf7] border border-[#0a3a60]/20 text-[#0a3a60]">
                                <i class="ph-bold ph-user-circle text-xs"></i>
                                {{ $role }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-slate-100 border border-slate-200 text-slate-600">
                                <i class="ph-bold ph-envelope-simple text-xs"></i>
                                {{ $user->email }}
                            </span>
                            @if($user->created_at)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-amber-50 border border-amber-200 text-[#d97d10]">
                                    <i class="ph-bold ph-calendar-check text-xs"></i>
                                    Joined {{ $user->created_at->format('M Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Information & Password -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-[#e0edf7] text-[#0a3a60] flex items-center justify-center shrink-0">
                        <i class="ph-bold ph-user text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">{{ __('Profile Information') }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Update your name and email address.</p>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-[#fde9d0] text-[#d97d10] flex items-center justify-center shrink-0">
                        <i class="ph-bold ph-lock-key text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">{{ __('Update Password') }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Keep your account secure with a strong password.</p>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="bg-white rounded-2xl border border-rose-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-rose-100 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <i class="ph-bold ph-trash text-lg"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">{{ __('Delete Account') }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Permanently remove your account and all associated data.</p>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-dynamic-component>
