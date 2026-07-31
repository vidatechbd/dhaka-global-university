<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Create Notice') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Post a new notice for students and staff.</p>
            </div>
            <a href="{{ route('admin.notices.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">
                <i class="ph-bold ph-arrow-left"></i>
                Back to Notices
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <x-admin.card title="Notice Details" subtitle="Fill in the details below to create a new notice." icon="ph-bold ph-megaphone-simple">
            <form action="{{ route('admin.notices.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="title" :value="__('Notice Title')" />
                    <x-text-input id="title" class="mt-2 w-full" type="text" name="title" :value="old('title')" placeholder="e.g. Library Closure on Public Holiday" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="content" :value="__('Notice Content')" />
                    <textarea id="content" name="content" rows="6" class="mt-2 block w-full border border-slate-300 focus:border-primary focus:ring-1 focus:ring-primary rounded-lg p-3 text-xs text-slate-800 outline-none" placeholder="Write the notice content here..." required>{{ old('content') }}</textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="file" :value="__('Attachment (PDF/Doc/Image)')" />
                        <label for="file" class="mt-2 flex items-center justify-center gap-2 px-4 py-6 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 hover:border-primary/50 hover:bg-[#f6fafc] cursor-pointer transition-colors text-slate-500">
                            <i class="ph-bold ph-paperclip text-lg text-primary"></i>
                            <span class="text-xs font-semibold">Attach a supporting file (optional)</span>
                        </label>
                        <input id="file" type="file" name="file" class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp">
                        <x-input-error :messages="$errors->get('file')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Publish Status')" />
                        <select id="status" name="status" class="mt-2 block w-full border border-slate-300 focus:border-primary focus:ring-primary rounded-lg shadow-sm px-3 py-2 text-sm text-slate-800 bg-white">
                            <option value="published">{{ __('Published') }}</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1.5">Draft notices are hidden from the public site.</p>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-end gap-3 pt-5 border-t border-slate-100">
                    <x-admin.btn href="{{ route('admin.notices.index') }}" variant="outline" size="md">
                        {{ __('Cancel') }}
                    </x-admin.btn>
                    <x-admin.btn type="submit" variant="primary" size="md">
                        <i class="ph-bold ph-megaphone-simple text-xs"></i>
                        {{ __('Save Notice') }}
                    </x-admin.btn>
                </div>
            </form>
        </x-admin.card>
    </div>
</x-admin-layout>
