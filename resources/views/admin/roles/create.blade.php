<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Create New Role') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Define a new role and assign its permissions.</p>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">
                <i class="ph-bold ph-arrow-left"></i>
                Back to Roles
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <x-admin.card title="Role Details" subtitle="Create a new role and choose its permissions." icon="ph-bold ph-user-plus">
            <form method="POST" action="{{ route('admin.roles.store') }}" class="flex flex-col gap-6">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Role Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-2 w-full" placeholder="e.g. Moderator" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <h3 class="font-bold text-sm text-slate-700 mb-3">{{ __('Assign Permissions') }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($permissions as $permission)
                            <label class="inline-flex items-center gap-3 text-xs font-semibold text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100 hover:border-primary/40 hover:bg-[#f6fafc] transition duration-150 cursor-pointer group">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                       class="rounded border-slate-300 text-primary shadow-sm focus:ring-primary focus:ring-offset-0 accent-primary">
                                <span class="group-hover:text-primary transition-colors">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-5 border-t border-slate-100">
                    <x-admin.btn type="submit" variant="primary" size="md">
                        <i class="ph-bold ph-check text-xs"></i>
                        {{ __('Save Role') }}
                    </x-admin.btn>
                    <x-admin.btn href="{{ route('admin.roles.index') }}" variant="outline" size="md">
                        {{ __('Cancel') }}
                    </x-admin.btn>
                </div>
            </form>
        </x-admin.card>
    </div>
</x-admin-layout>
