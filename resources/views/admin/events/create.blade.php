<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h1 class="text-xl font-bold text-gray-800">{{ __('Create Event') }}</h1>
        </div>
    </x-slot>

    <!-- Load CDN packages in slot -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <div class="max-w-4xl bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- Thumbnail, Event Date & Status (Grid layout) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Thumbnail -->
                <div>
                    <x-input-label for="thumbnail" :value="__('Thumbnail Image')" />
                    <input id="thumbnail" type="file" name="thumbnail" class="mt-1 block w-full border border-gray-300 rounded-lg p-2 text-xs focus:border-blue-500 focus:ring-blue-500 shadow-sm" accept="image/*">
                    <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                </div>

                <!-- Event Date -->
                <div>
                    <x-input-label for="event_date" :value="__('Event Date')" />
                    <input id="event_date" type="date" name="event_date" value="{{ old('event_date') }}" class="mt-1 block w-full border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm px-3 py-2 text-xs bg-white">
                    <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                </div>

                <!-- Status -->
                <div>
                    <x-input-label for="status" :value="__('Status')" />
                    <select id="status" name="status" class="mt-1 block w-full border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm px-3 py-2 text-sm bg-white">
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
            </div>

            <!-- Content (Summernote) -->
            <div>
                <x-input-label for="summernote" :value="__('Content')" />
                <div class="mt-1">
                    <textarea id="summernote" name="content" required>{{ old('content') }}</textarea>
                </div>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.events.index') }}" class="px-4 py-2 border border-gray-200 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow transition">
                    Publish Event
                </button>
            </div>
        </form>
    </div>

    <!-- Summernote Init -->
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Write your event content here...',
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
        });
    </script>
</x-admin-layout>
