<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">{{ __('Create Page') }}</h1>
        </div>
    </x-slot>

    <!-- Load Summernote Lite Assets -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <div class="max-w-4xl bg-white rounded-lg shadow-sm border border-gray-300 p-6">
        <form action="{{ route('admin.pages.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2" type="text" name="title" :value="old('title')" required autofocus placeholder="e.g. Terms of Service" />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- Slug -->
            <div>
                <x-input-label for="slug" :value="__('Slug (Leave empty to generate automatically)')" />
                <x-text-input id="slug" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2" type="text" name="slug" :value="old('slug')" placeholder="e.g. terms-of-service" />
                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
            </div>

            <!-- Parent Page & Sort Order Selector -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="parent_id" :value="__('Parent Page')" />
                    <select id="parent_id" name="parent_id" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 text-sm bg-white">
                        <option value="">{{ __('None (Top Level)') }}</option>
                        @foreach($parentPages as $parentPage)
                            <option value="{{ $parentPage->id }}" {{ old('parent_id') == $parentPage->id ? 'selected' : '' }}>
                                {{ $parentPage->title }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="sort_order" :value="__('Sort Order (Lower numbers show first)')" />
                    <x-text-input id="sort_order" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="number" name="sort_order" :value="old('sort_order', 0)" min="0" required />
                    <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
                </div>
            </div>

            <!-- Content (Summernote) -->
            <div>
                <x-input-label for="summernote" :value="__('Content')" />
                <div class="mt-1 border border-gray-300 rounded-md overflow-hidden">
                    <textarea id="summernote" name="content" required>{{ old('content') }}</textarea>
                </div>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-300">
                <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-xs font-semibold rounded-md hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-md shadow transition">
                    Create Page
                </button>
            </div>
        </form>
    </div>

    <!-- Summernote Init -->
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Write your page content here...',
                tabsize: 2,
                height: 350,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'pre']
            });
            $('.note-editor').addClass('border-0');
            $('.note-toolbar').addClass('bg-gray-50 border-b border-gray-300');
        });
    </script>
</x-admin-layout>
