<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-gray-800">{{ __('Edit Notice') }}</h1>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.notices.update', $notice) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <x-input-label for="title" :value="__('Notice Title')" />
                <x-text-input id="title" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" name="title" :value="old('title', $notice->title)" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="content" :value="__('Notice Content')" />
                <textarea id="content" name="content" rows="6" class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-xs outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>{{ old('content', $notice->content) }}</textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="file" :value="__('Replace Attachment (PDF/Doc/Image)')" />
                    <input id="file" type="file" name="file" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-xs" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp">
                    @if($notice->file_path)
                        <div class="mt-2 text-[10px] text-gray-500 flex items-center gap-1">
                            <i class="ph ph-file-pdf text-sm text-blue-600"></i> Current: 
                            <a href="{{ asset($notice->file_path) }}" target="_blank" class="text-blue-600 hover:underline font-semibold">{{ basename($notice->file_path) }}</a>
                        </div>
                    @endif
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="status" :value="__('Publish Status')" />
                    <select id="status" name="status" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-xs">
                        <option value="published" {{ $notice->status === 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                        <option value="draft" {{ $notice->status === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.notices.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-50 transition">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow transition">
                    {{ __('Update Notice') }}
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
