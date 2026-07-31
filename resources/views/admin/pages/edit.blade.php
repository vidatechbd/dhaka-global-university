<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Edit Page') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Update the page details below.</p>
            </div>
            <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">
                <i class="ph-bold ph-arrow-left"></i>
                Back to Pages
            </a>
        </div>
    </x-slot>

    <!-- Load Summernote Lite Assets -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <div class="max-w-4xl">
        <x-admin.card title="Page Details" subtitle="Update the page details below." icon="ph-bold ph-file-text">
            <form action="{{ route('admin.pages.update', $page) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Title -->
                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="mt-2 w-full" type="text" name="title" :value="old('title', $page->title)" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Slug -->
                <div>
                    <x-input-label for="slug" :value="__('Slug')" />
                    <x-text-input id="slug" class="mt-2 w-full" type="text" name="slug" :value="old('slug', $page->slug)" required />
                    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                </div>

                <!-- Parent Page & Sort Order -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="parent_id" :value="__('Parent Page')" />
                        <select id="parent_id" name="parent_id" class="mt-2 block w-full border border-slate-300 focus:border-primary focus:ring-primary rounded-lg shadow-sm px-3 py-2 text-sm text-slate-800 bg-white">
                            <option value="">{{ __('None (Top Level)') }}</option>
                            @foreach($parentPages as $parentPage)
                                <option value="{{ $parentPage->id }}" {{ old('parent_id', $page->parent_id) == $parentPage->id ? 'selected' : '' }}>
                                    {{ $parentPage->title }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="sort_order" :value="__('Sort Order (Lower numbers show first)')" />
                        <x-text-input id="sort_order" class="mt-2 w-full" type="number" name="sort_order" :value="old('sort_order', $page->sort_order ?? 0)" min="0" required />
                        <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
                    </div>
                </div>

                <!-- Content (Summernote) -->
                <div>
                    <x-input-label for="summernote" :value="__('Content')" />
                    <div class="mt-2 border border-slate-200 rounded-xl overflow-hidden">
                        <textarea id="summernote" name="content" required>{{ old('content', $page->content) }}</textarea>
                    </div>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
                    <x-admin.btn href="{{ route('admin.pages.index') }}" variant="outline" size="md">
                        Cancel
                    </x-admin.btn>
                    <x-admin.btn type="submit" variant="primary" size="md">
                        <i class="ph-bold ph-floppy-disk text-xs"></i>
                        Update Page
                    </x-admin.btn>
                </div>
            </form>
        </x-admin.card>
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
            $('.note-toolbar').addClass('bg-slate-50 border-b border-slate-200');
        });
    </script>
</x-admin-layout>
