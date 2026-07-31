<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Edit Notice') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Update the notice details below.</p>
            </div>
            <a href="{{ route('admin.notices.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">
                <i class="ph-bold ph-arrow-left"></i>
                Back to Notices
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <x-admin.card title="Notice Details" subtitle="Update the notice details below." icon="ph-bold ph-megaphone-simple">
            <form action="{{ route('admin.notices.update', $notice) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="title" :value="__('Notice Title')" />
                    <x-text-input id="title" class="mt-2 w-full" type="text" name="title" :value="old('title', $notice->title)" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="content" :value="__('Notice Content')" />
                    <textarea id="content" name="content" rows="6" class="mt-2 block w-full border border-slate-300 focus:border-primary focus:ring-1 focus:ring-primary rounded-lg p-3 text-xs text-slate-800 outline-none" required>{{ old('content', $notice->content) }}</textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="file" :value="__('Replace Attachment (PDF/Doc/Image)')" />
                        @if($notice->file_path)
                            <div class="mt-2 mb-3 flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <div class="w-9 h-9 rounded-lg bg-[#fde9d0] text-[#d97d10] flex items-center justify-center shrink-0">
                                    <i class="ph-bold ph-file-pdf"></i>
                                </div>
                                <div class="min-w-0">
                                    <span class="block text-xs font-bold text-slate-600 truncate">{{ basename($notice->file_path) }}</span>
                                    <a href="{{ asset($notice->file_path) }}" target="_blank" class="text-[10px] font-semibold text-primary hover:underline">View current file</a>
                                </div>
                            </div>
                        @endif
                        <label for="file" class="mt-2 flex items-center justify-center gap-2 px-4 py-6 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 hover:border-primary/50 hover:bg-[#f6fafc] cursor-pointer transition-colors text-slate-500">
                            <i class="ph-bold ph-paperclip text-lg text-primary"></i>
                            <span class="text-xs font-semibold">Click to replace the attachment</span>
                        </label>
                        <input id="file" type="file" name="file" class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp">
                        <x-input-error :messages="$errors->get('file')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Publish Status')" />
                        <select id="status" name="status" class="mt-2 block w-full border border-slate-300 focus:border-primary focus:ring-primary rounded-lg shadow-sm px-3 py-2 text-sm text-slate-800 bg-white">
                            <option value="published" {{ old('status', $notice->status) === 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                            <option value="draft" {{ old('status', $notice->status) === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
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
                        <i class="ph-bold ph-floppy-disk text-xs"></i>
                        {{ __('Update Notice') }}
                    </x-admin.btn>
                </div>
            </form>
        </x-admin.card>
    </div>
</x-admin-layout>
