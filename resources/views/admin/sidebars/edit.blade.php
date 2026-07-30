<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-800">{{ __('Edit Sidebar') }}</h1>
            <a href="{{ route('admin.sidebars.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-700 flex items-center gap-1">
                &larr; Back to Sidebars
            </a>
        </div>
    </x-slot>

    <!-- Alpine JS dynamic widget builder -->
    <div x-data="{
        widgets: @json(array_map(function($c) {
            return [
                'type' => $c['type'],
                'title' => $c['title'],
                'content' => $c['content'],
                'links' => $c['type'] === 'links' ? (json_decode($c['content'], true) ?: []) : [['title' => '', 'url' => '#']],
                'sort_order' => $c['sort_order']
            ];
        }, $sidebar->contents->toArray())),
        addWidget(type) {
            this.widgets.push({
                type: type,
                title: '',
                content: '',
                links: [{ title: '', url: '#' }],
                sort_order: this.widgets.length
            });
        },
        removeWidget(index) {
            this.widgets.splice(index, 1);
        },
        addLink(widgetIndex) {
            this.widgets[widgetIndex].links.push({ title: '', url: '#' });
        },
        removeLink(widgetIndex, linkIndex) {
            this.widgets[widgetIndex].links.splice(linkIndex, 1);
        }
    }" class="space-y-6">

        <form action="{{ route('admin.sidebars.update', $sidebar) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-300 p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Sidebar Name -->
            <div>
                <x-input-label for="name" :value="__('Sidebar Name')" />
                <x-text-input id="name" name="name" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" required :value="old('name', $sidebar->name)" placeholder="e.g. Admission Side Nav" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Content Blocks / Widgets Container -->
            <div class="border-t border-gray-200 pt-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Content Blocks / Widgets</h3>
                    <div class="flex gap-2">
                        <button type="button" @click="addWidget('html')" class="px-3 py-1.5 bg-indigo-50 border border-indigo-200 hover:bg-indigo-100 text-indigo-700 rounded text-[10px] font-bold uppercase transition">
                            + Add Custom HTML
                        </button>
                        <button type="button" @click="addWidget('links')" class="px-3 py-1.5 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 text-emerald-700 rounded text-[10px] font-bold uppercase transition">
                            + Add Link List
                        </button>
                    </div>
                </div>

                <!-- Empty state -->
                <template x-if="widgets.length === 0">
                    <div class="text-center py-10 border-2 border-dashed border-gray-200 rounded-lg text-gray-400 text-xs">
                        No widgets added to this sidebar yet. Click one of the buttons above to add content.
                    </div>
                </template>

                <!-- Widgets List -->
                <div class="space-y-4">
                    <template x-for="(widget, wIdx) in widgets" :key="wIdx">
                        <div class="border border-gray-300 rounded-lg bg-gray-50/50 p-4 space-y-4 relative">
                            <button type="button" @click="removeWidget(wIdx)" class="absolute top-4 right-4 text-red-500 hover:text-red-700 text-xs font-bold">
                                Remove Block
                            </button>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-700">Block Title</label>
                                    <input type="text" :name="'contents['+wIdx+'][title]'" x-model="widget.title" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-xs bg-white" placeholder="e.g. Helpful Links or Notice" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700">Sort Order</label>
                                    <input type="number" :name="'contents['+wIdx+'][sort_order]'" x-model="widget.sort_order" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-xs bg-white">
                                    <input type="hidden" :name="'contents['+wIdx+'][type]'" :value="widget.type">
                                </div>
                            </div>

                            <!-- Conditional Fields based on Widget Type -->
                            
                            <!-- 1. HTML Type -->
                            <template x-if="widget.type === 'html'">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700">Custom HTML / Text Content</label>
                                    <textarea :name="'contents['+wIdx+'][content]'" x-model="widget.content" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md p-3 text-xs bg-white" placeholder="Enter HTML or plain text here..."></textarea>
                                </div>
                            </template>

                            <!-- 2. Links Type -->
                            <template x-if="widget.type === 'links'">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between border-b pb-1">
                                        <span class="text-xs font-bold text-gray-700">Links List</span>
                                        <button type="button" @click="addLink(wIdx)" class="text-xs text-blue-600 hover:text-blue-800 font-bold">+ Add Link Row</button>
                                    </div>
                                    <div class="space-y-2">
                                        <template x-for="(link, lIdx) in widget.links" :key="lIdx">
                                            <div class="flex gap-3 items-center">
                                                <input type="text" :name="'contents['+wIdx+'][link_titles]['+lIdx+']'" x-model="link.title" class="block w-1/2 border border-gray-300 rounded-md px-3 py-1.5 text-xs bg-white" placeholder="Link Title" required>
                                                <input type="text" :name="'contents['+wIdx+'][link_urls]['+lIdx+']'" x-model="link.url" class="block w-1/2 border border-gray-300 rounded-md px-3 py-1.5 text-xs bg-white" placeholder="URL (e.g. /admissions or https://...)" required>
                                                <button type="button" @click="removeLink(wIdx, lIdx)" class="text-red-500 hover:text-red-700 text-xs font-bold">Remove</button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded shadow transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
