<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Edit Role') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">{{ $role->name }} &middot; update the role name and permissions.</p>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">
                <i class="ph-bold ph-arrow-left"></i>
                Back to Roles
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 text-xs font-medium rounded-r-lg flex items-center gap-2" role="alert">
                <i class="ph-bold ph-warning-circle text-base"></i>
                {{ session('error') }}
            </div>
        @endif

        <x-admin.card title="Role Details" subtitle="Update the role and its permissions." icon="ph-bold ph-user-gear">
            <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="flex flex-col gap-6">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="name" :value="__('Role Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-2 w-full"
                                  value="{{ old('name', $role->name) }}" required
                                  :disabled="$role->name === 'Principal'" />
                    @if($role->name === 'Principal')
                        <p class="text-xs text-amber-600 font-semibold mt-1.5 flex items-center gap-1">
                            <i class="ph-bold ph-lock-simple text-xs"></i>
                            {{ __('The Principal role name cannot be modified.') }}
                        </p>
                    @endif
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <h3 class="font-bold text-sm text-slate-700 mb-3">{{ __('Assign Permissions') }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($permissions as $permission)
                            <label class="inline-flex items-center gap-3 text-xs font-semibold text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100 hover:border-primary/40 hover:bg-[#f6fafc] transition duration-150 cursor-pointer group">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                       class="rounded border-slate-300 text-primary shadow-sm focus:ring-primary focus:ring-offset-0 accent-primary"
                                       {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                <span class="group-hover:text-primary transition-colors">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-5 border-t border-slate-100">
                    <x-admin.btn type="submit" variant="primary" size="md">
                        <i class="ph-bold ph-check text-xs"></i>
                        {{ __('Update Role') }}
                    </x-admin.btn>
                    <x-admin.btn href="{{ route('admin.roles.index') }}" variant="outline" size="md">
                        {{ __('Cancel') }}
                    </x-admin.btn>
                </div>
            </form>
        </x-admin.card>
    </div>
</x-admin-layout>
