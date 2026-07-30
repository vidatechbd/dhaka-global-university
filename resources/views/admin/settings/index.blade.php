<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-gray-800">{{ __('University Settings') }}</h1>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-xs font-medium rounded-r-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Card 1: General & Branding -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
                <h2 class="text-base font-bold text-[#072740] border-b border-gray-100 pb-3 flex items-center gap-2">
                    🎓 University Branding & Details
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <x-input-label for="name" :value="__('University Name')" />
                        <x-text-input id="name" class="block mt-1 w-full text-xs" type="text" name="name" :value="old('name', $setting->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="logo" :value="__('University Logo (WebP Compressed)')" />
                        @if($setting->logo)
                            <div class="mt-2 mb-2 flex items-center gap-3">
                                <img src="{{ asset($setting->logo) }}" alt="Logo" class="h-12 object-contain p-1 border border-gray-200 rounded-lg">
                                <span class="text-xs text-gray-400">Current Logo</span>
                            </div>
                        @endif
                        <input id="logo" type="file" name="logo" class="mt-1 block w-full border border-gray-300 rounded-lg p-2 text-xs focus:border-blue-500 focus:ring-blue-500 shadow-sm" accept="image/*">
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="favicon" :value="__('Favicon (ICO or PNG)')" />
                        @if($setting->favicon)
                            <div class="mt-2 mb-2 flex items-center gap-3">
                                <img src="{{ asset($setting->favicon) }}" alt="Favicon" class="w-8 h-8 object-contain p-1 border border-gray-200 rounded-lg">
                                <span class="text-xs text-gray-400">Current Favicon</span>
                            </div>
                        @endif
                        <input id="favicon" type="file" name="favicon" class="mt-1 block w-full border border-gray-300 rounded-lg p-2 text-xs focus:border-blue-500 focus:ring-blue-500 shadow-sm" accept="image/*,.ico">
                        <x-input-error :messages="$errors->get('favicon')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="address" :value="__('Physical Address')" />
                    <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-xs">{{ old('address', $setting->address) }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
            </div>

            <!-- Card 2: Multiple Contacts -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h2 class="text-base font-bold text-[#072740] flex items-center gap-2">
                        📞 Contact Information
                    </h2>
                    <button type="button" onclick="addContactRow()" class="text-xs bg-[#0a3a60]/10 text-[#0a3a60] hover:bg-[#0a3a60] hover:text-white px-3 py-1.5 rounded-lg font-semibold transition-colors flex items-center gap-1">
                        + Add Contact
                    </button>
                </div>

                <div id="contacts-container" class="space-y-3">
                    @php
                        $contacts = old('contacts', $setting->contacts ?: []);
                    @endphp
                    @forelse($contacts as $idx => $contact)
                        <div class="grid grid-cols-12 gap-3 items-center bg-gray-50 p-3 rounded-xl border border-gray-200" id="contact-row-{{ $idx }}">
                            <div class="col-span-4">
                                <input type="text" name="contacts[{{ $idx }}][type]" value="{{ $contact['type'] ?? '' }}" placeholder="e.g. Phone, Email, Hotline" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-[#0a3a60]">
                            </div>
                            <div class="col-span-7">
                                <input type="text" name="contacts[{{ $idx }}][value]" value="{{ $contact['value'] ?? '' }}" placeholder="Value (e.g. +880 123456, info@domain.com)" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-[#0a3a60]">
                            </div>
                            <div class="col-span-1 text-right">
                                <button type="button" onclick="document.getElementById('contact-row-{{ $idx }}').remove()" class="p-2 text-red-400 hover:text-red-600 rounded-lg transition-colors">
                                    ✕
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="grid grid-cols-12 gap-3 items-center bg-gray-50 p-3 rounded-xl border border-gray-200" id="contact-row-0">
                            <div class="col-span-4">
                                <input type="text" name="contacts[0][type]" value="Phone" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-[#0a3a60]">
                            </div>
                            <div class="col-span-7">
                                <input type="text" name="contacts[0][value]" value="+880 1234 567890" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-[#0a3a60]">
                            </div>
                            <div class="col-span-1 text-right">
                                <button type="button" onclick="document.getElementById('contact-row-0').remove()" class="p-2 text-red-400 hover:text-red-600 rounded-lg transition-colors">
                                    ✕
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Card 3: Multiple Social Media Links -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h2 class="text-base font-bold text-[#072740] flex items-center gap-2">
                        🌐 Social Media Channels
                    </h2>
                    <button type="button" onclick="addSocialRow()" class="text-xs bg-[#0a3a60]/10 text-[#0a3a60] hover:bg-[#0a3a60] hover:text-white px-3 py-1.5 rounded-lg font-semibold transition-colors flex items-center gap-1">
                        + Add Channel
                    </button>
                </div>

                <div id="socials-container" class="space-y-3">
                    @php
                        $socials = old('social_medias', $setting->social_medias ?: []);
                    @endphp
                    @forelse($socials as $idx => $social)
                        <div class="grid grid-cols-12 gap-3 items-center bg-gray-50 p-3 rounded-xl border border-gray-200" id="social-row-{{ $idx }}">
                            <div class="col-span-4">
                                <input type="text" name="social_medias[{{ $idx }}][platform]" value="{{ $social['platform'] ?? '' }}" placeholder="e.g. Facebook, YouTube" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-[#0a3a60]">
                            </div>
                            <div class="col-span-7">
                                <input type="url" name="social_medias[{{ $idx }}][url]" value="{{ $social['url'] ?? '' }}" placeholder="https://..." class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-[#0a3a60]">
                            </div>
                            <div class="col-span-1 text-right">
                                <button type="button" onclick="document.getElementById('social-row-{{ $idx }}').remove()" class="p-2 text-red-400 hover:text-red-600 rounded-lg transition-colors">
                                    ✕
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="grid grid-cols-12 gap-3 items-center bg-gray-50 p-3 rounded-xl border border-gray-200" id="social-row-0">
                            <div class="col-span-4">
                                <input type="text" name="social_medias[0][platform]" value="Facebook" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-[#0a3a60]">
                            </div>
                            <div class="col-span-7">
                                <input type="url" name="social_medias[0][url]" value="https://facebook.com" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-[#0a3a60]">
                            </div>
                            <div class="col-span-1 text-right">
                                <button type="button" onclick="document.getElementById('social-row-0').remove()" class="p-2 text-red-400 hover:text-red-600 rounded-lg transition-colors">
                                    ✕
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Card 4: SEO Settings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
                <h2 class="text-base font-bold text-[#072740] border-b border-gray-100 pb-3 flex items-center gap-2">
                    🔍 SEO & Meta Settings
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="meta_title" :value="__('Meta Title')" />
                        <x-text-input id="meta_title" class="block mt-1 w-full text-xs" type="text" name="meta_title" :value="old('meta_title', $setting->meta_title)" placeholder="e.g. Dhaka Global University | Center for Learning" />
                        <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="meta_author" :value="__('Meta Author')" />
                        <x-text-input id="meta_author" class="block mt-1 w-full text-xs" type="text" name="meta_author" :value="old('meta_author', $setting->meta_author)" placeholder="e.g. Dhaka Global University" />
                        <x-input-error :messages="$errors->get('meta_author')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="meta_keywords" :value="__('Meta Keywords (Comma separated)')" />
                    <x-text-input id="meta_keywords" class="block mt-1 w-full text-xs" type="text" name="meta_keywords" :value="old('meta_keywords', $setting->meta_keywords)" placeholder="e.g. education, university, dhaka global university, admission" />
                    <x-input-error :messages="$errors->get('meta_keywords')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="meta_description" :value="__('Meta Description')" />
                    <textarea id="meta_description" name="meta_description" rows="3" class="mt-1 block w-full border border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-xs" placeholder="Describe your university for search engines...">{{ old('meta_description', $setting->meta_description) }}</textarea>
                    <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4">
                <button type="submit" class="px-6 py-2.5 bg-[#0a3a60] hover:bg-[#072740] text-white text-xs font-bold rounded-xl shadow transition">
                    Save Settings
                </button>
            </div>
        </form>
    </div>

    <script>
        function addContactRow() {
            const container = document.getElementById('contacts-container');
            const idx = Date.now();
            const html = `
                <div class="grid grid-cols-12 gap-3 items-center bg-gray-50 p-3 rounded-xl border border-gray-200" id="contact-row-${idx}">
                    <div class="col-span-4">
                        <input type="text" name="contacts[${idx}][type]" placeholder="e.g. Phone, Email, Hotline" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-[#0a3a60]">
                    </div>
                    <div class="col-span-7">
                        <input type="text" name="contacts[${idx}][value]" placeholder="Value" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-[#0a3a60]">
                    </div>
                    <div class="col-span-1 text-right">
                        <button type="button" onclick="document.getElementById('contact-row-${idx}').remove()" class="p-2 text-red-400 hover:text-red-600 rounded-lg transition-colors">
                            ✕
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function addSocialRow() {
            const container = document.getElementById('socials-container');
            const idx = Date.now();
            const html = `
                <div class="grid grid-cols-12 gap-3 items-center bg-gray-50 p-3 rounded-xl border border-gray-200" id="social-row-${idx}">
                    <div class="col-span-4">
                        <input type="text" name="social_medias[${idx}][platform]" placeholder="e.g. YouTube, Twitter" class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-[#0a3a60]">
                    </div>
                    <div class="col-span-7">
                        <input type="url" name="social_medias[${idx}][url]" placeholder="https://..." class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs outline-none focus:border-[#0a3a60]">
                    </div>
                    <div class="col-span-1 text-right">
                        <button type="button" onclick="document.getElementById('social-row-${idx}').remove()" class="p-2 text-red-400 hover:text-red-600 rounded-lg transition-colors">
                            ✕
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }
    </script>
</x-admin-layout>
