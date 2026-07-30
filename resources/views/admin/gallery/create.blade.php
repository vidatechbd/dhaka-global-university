<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-gray-800">{{ __('Add Image to Gallery') }}</h1>
    </x-slot>

    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="title" :value="__('Caption / Title')" />
                <x-text-input id="title" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" name="title" :value="old('title')" required autofocus placeholder="e.g. Feni University Convocation 2026" />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="image" :value="__('Upload Photo')" />
                <input id="image" type="file" name="image" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-xs" accept="image/*" required>
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="category" :value="__('Category')" />
                    <x-text-input id="category" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" name="category" :value="old('category', 'Campus')" placeholder="e.g. Campus, Sports, Convocation" />
                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="status" :value="__('Publish Status')" />
                    <select id="status" name="status" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-xs">
                        <option value="published">{{ __('Published') }}</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.gallery.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-50 transition">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow transition">
                    {{ __('Save Image') }}
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
