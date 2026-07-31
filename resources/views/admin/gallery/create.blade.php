<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Add Image to Gallery') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Upload a new photo to the campus gallery.</p>
            </div>
            <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">
                <i class="ph-bold ph-arrow-left"></i>
                Back to Gallery
            </a>
        </div>
    </x-slot>

    <div class="max-w-xl">
        <x-admin.card title="Photo Details" subtitle="Fill in the details below to add a new photo." icon="ph-bold ph-image-square">
            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="title" :value="__('Caption / Title')" />
                    <x-text-input id="title" class="mt-2 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="e.g. Feni University Convocation 2026" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="image" :value="__('Upload Photo')" />
                    <label for="image" class="mt-2 flex flex-col items-center justify-center gap-2 px-4 py-10 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 hover:border-primary/50 hover:bg-[#f6fafc] cursor-pointer transition-colors text-slate-500">
                        <i class="ph-bold ph-image text-2xl text-primary"></i>
                        <span class="text-xs font-semibold">Click to upload a photo</span>
                        <span class="text-[10px] text-slate-400">JPG, PNG, WebP supported</span>
                    </label>
                    <input id="image" type="file" name="image" class="hidden" accept="image/*" required>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="category" :value="__('Category')" />
                        <x-text-input id="category" class="mt-2 w-full" type="text" name="category" :value="old('category', 'Campus')" placeholder="e.g. Campus, Sports, Convocation" />
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Publish Status')" />
                        <select id="status" name="status" class="mt-2 block w-full border border-slate-300 focus:border-primary focus:ring-primary rounded-lg shadow-sm px-3 py-2 text-sm text-slate-800 bg-white">
                            <option value="published">{{ __('Published') }}</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-end gap-3 pt-5 border-t border-slate-100">
                    <x-admin.btn href="{{ route('admin.gallery.index') }}" variant="outline" size="md">
                        {{ __('Cancel') }}
                    </x-admin.btn>
                    <x-admin.btn type="submit" variant="primary" size="md">
                        <i class="ph-bold ph-floppy-disk text-xs"></i>
                        {{ __('Save Image') }}
                    </x-admin.btn>
                </div>
            </form>
        </x-admin.card>
    </div>
</x-admin-layout>
