<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3 w-full">
            <div>
                <h1 class="text-xl font-bold text-primary">{{ __('Edit Event') }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Update the event details below.</p>
            </div>
            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">
                <i class="ph-bold ph-arrow-left"></i>
                Back to Events
            </a>
        </div>
    </x-slot>

    <!-- Load CDN packages in slot -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <div class="max-w-4xl">
        <x-admin.card title="Event Details" subtitle="Update the event details below." icon="ph-bold ph-calendar-star">
            <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Title -->
                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="mt-2 w-full" type="text" name="title" :value="old('title', $event->title)" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Thumbnail, Event Date & Status -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Thumbnail -->
                    <div>
                        <x-input-label for="thumbnail" :value="__('Thumbnail Image')" />
                        @if($event->thumbnail)
                            <div class="mt-2 mb-3 flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <img src="{{ asset($event->thumbnail) }}" alt="Thumbnail" class="w-20 h-14 object-cover rounded-lg border border-slate-200">
                                <div>
                                    <span class="block text-xs font-bold text-slate-600">Current Thumbnail</span>
                                    <span class="block text-[10px] text-slate-400 mt-0.5">Upload a new image to replace it</span>
                                </div>
                            </div>
                        @endif
                        <label for="thumbnail" class="mt-2 flex items-center justify-center gap-2 px-4 py-6 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 hover:border-primary/50 hover:bg-[#f6fafc] cursor-pointer transition-colors text-slate-500">
                            <i class="ph-bold ph-upload-simple text-lg text-primary"></i>
                            <span class="text-xs font-semibold">Click to replace the image</span>
                        </label>
                        <input id="thumbnail" type="file" name="thumbnail" class="hidden" accept="image/*">
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>

                    <!-- Event Date -->
                    <div>
                        <x-input-label for="event_date" :value="__('Event Date')" />
                        <input id="event_date" type="date" name="event_date" value="{{ old('event_date', $event->event_date ? $event->event_date->format('Y-m-d') : '') }}" class="mt-2 block w-full border border-slate-300 focus:border-primary focus:ring-primary rounded-lg shadow-sm px-3 py-2 text-sm text-slate-800 bg-white">
                        <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div>
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status" class="mt-2 block w-full border border-slate-300 focus:border-primary focus:ring-primary rounded-lg shadow-sm px-3 py-2 text-sm text-slate-800 bg-white">
                            <option value="published" {{ old('status', $event->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status', $event->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1.5">Draft events are hidden from the public site.</p>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                </div>

                <!-- Content (Summernote) -->
                <div>
                    <x-input-label for="summernote" :value="__('Content')" />
                    <div class="mt-2">
                        <textarea id="summernote" name="content" required>{{ old('content', $event->content) }}</textarea>
                    </div>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <!-- Buttons -->
                <div class="flex flex-wrap items-center justify-end gap-3 pt-5 border-t border-slate-100">
                    <x-admin.btn href="{{ route('admin.events.index') }}" variant="outline" size="md">
                        Cancel
                    </x-admin.btn>
                    <x-admin.btn type="submit" variant="primary" size="md">
                        <i class="ph-bold ph-floppy-disk text-xs"></i>
                        Update Event
                    </x-admin.btn>
                </div>
            </form>
        </x-admin.card>
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
