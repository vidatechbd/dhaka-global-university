<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Edit Gallery Image') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Update the photo details below.</p>
            </div>
            <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">
                <i class="ph-bold ph-arrow-left"></i>
                Back to Gallery
            </a>
        </div>
    </x-slot>

    <div class="max-w-xl">
        <x-admin.card title="Photo Details" subtitle="Update the photo details below." icon="ph-bold ph-image-square">
            <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="title" :value="__('Caption / Title')" />
                    <x-text-input id="title" class="mt-2 w-full" type="text" name="title" :value="old('title', $gallery->title)" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="image" :value="__('Replace Photo (Leave blank to keep current)')" />
                    @if($gallery->image_path)
                        <div class="mt-2 mb-3 flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <img src="{{ asset($gallery->image_path) }}" alt="{{ $gallery->title }}" class="h-24 w-36 object-cover rounded-lg border border-slate-200">
                            <div>
                                <span class="block text-xs font-bold text-slate-600">Current Photo</span>
                                <span class="block text-[10px] text-slate-400 mt-0.5">Upload a new image to replace it</span>
                            </div>
                        </div>
                    @endif
                    <label for="image" class="mt-2 flex items-center justify-center gap-2 px-4 py-6 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 hover:border-primary/50 hover:bg-[#f6fafc] cursor-pointer transition-colors text-slate-500">
                        <i class="ph-bold ph-upload-simple text-lg text-primary"></i>
                        <span class="text-xs font-semibold">Click to replace the photo</span>
                    </label>
                    <input id="image" type="file" name="image" class="hidden" accept="image/*">
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="category" :value="__('Category')" />
                        <x-text-input id="category" class="mt-2 w-full" type="text" name="category" :value="old('category', $gallery->category)" />
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Publish Status')" />
                        <select id="status" name="status" class="mt-2 block w-full border border-slate-300 focus:border-primary focus:ring-primary rounded-lg shadow-sm px-3 py-2 text-sm text-slate-800 bg-white">
                            <option value="published" {{ old('status', $gallery->status) === 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                            <option value="draft" {{ old('status', $gallery->status) === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
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
                        {{ __('Update Image') }}
                    </x-admin.btn>
                </div>
            </form>
        </x-admin.card>
    </div>
</x-admin-layout>
