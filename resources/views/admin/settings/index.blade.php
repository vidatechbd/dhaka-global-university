<x-admin-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-bold text-primary">{{ __('University Settings') }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Branding, contact details, social channels and SEO configuration.</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-xs font-medium rounded-r-lg shadow-sm flex items-center gap-2">
                <i class="ph-bold ph-check-circle text-base"></i>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Card 1: General & Branding -->
            <x-admin.card title="University Branding & Details" subtitle="Core identity information shown across the portal." icon="ph-bold ph-graduation-cap">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <x-input-label for="name" :value="__('University Name')" />
                        <x-text-input id="name" class="block mt-1.5 w-full text-xs" type="text" name="name" :value="old('name', $setting->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="logo" :value="__('University Logo (WebP Compressed)')" />
                        @if($setting->logo)
                            <div class="mt-2 mb-2 flex items-center gap-3">
                                <img src="{{ asset($setting->logo) }}" alt="Logo" class="h-12 object-contain p-1 border border-slate-200 rounded-lg">
                                <span class="text-xs text-slate-400">Current Logo</span>
                            </div>
                        @endif
                        <input id="logo" type="file" name="logo" class="mt-1.5 block w-full border border-slate-300 rounded-lg p-2 text-xs focus:border-primary focus:ring-primary shadow-sm bg-white" accept="image/*">
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="signature" :value="__('University Signature (PNG)')" />
                        @if($setting->signature)
                            <div class="mt-2 mb-2 flex items-center gap-3">
                                <img src="{{ asset($setting->signature) }}" alt="Signature" class="h-12 object-contain p-1 border border-slate-200 rounded-lg bg-white">
                                <span class="text-xs text-slate-400">Current Signature</span>
                            </div>
                        @endif
                        <input id="signature" type="file" name="signature" class="mt-1.5 block w-full border border-slate-300 rounded-lg p-2 text-xs focus:border-primary focus:ring-primary shadow-sm bg-white" accept="image/*">
                        <x-input-error :messages="$errors->get('signature')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="favicon" :value="__('Favicon (ICO or PNG)')" />
                        @if($setting->favicon)
                            <div class="mt-2 mb-2 flex items-center gap-3">
                                <img src="{{ asset($setting->favicon) }}" alt="Favicon" class="w-8 h-8 object-contain p-1 border border-slate-200 rounded-lg">
                                <span class="text-xs text-slate-400">Current Favicon</span>
                            </div>
                        @endif
                        <input id="favicon" type="file" name="favicon" class="mt-1.5 block w-full border border-slate-300 rounded-lg p-2 text-xs focus:border-primary focus:ring-primary shadow-sm bg-white" accept="image/*,.ico">
                        <x-input-error :messages="$errors->get('favicon')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-6">
                    <x-input-label for="address" :value="__('Physical Address')" />
                    <textarea id="address" name="address" rows="3" class="mt-1.5 block w-full border-slate-300 focus:border-primary focus:ring-primary rounded-lg shadow-sm text-xs">{{ old('address', $setting->address) }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
            </x-admin.card>

            <!-- Card 2: Multiple Contacts -->
            <x-admin.card title="Contact Information" subtitle="Phone numbers, emails and hotlines shown in the top bar and footer." icon="ph-bold ph-phone">
                <x-slot name="actions">
                    <x-admin.btn type="button" variant="navy-soft" size="sm" onclick="addContactRow()">
                        <i class="ph-bold ph-plus text-xs"></i>
                        Add Contact
                    </x-admin.btn>
                </x-slot>

                <div id="contacts-container" class="space-y-3">
                    @php
                        $contacts = old('contacts', $setting->contacts ?: []);
                    @endphp
                    @forelse($contacts as $idx => $contact)
                        <div class="grid grid-cols-12 gap-3 items-center bg-slate-50 p-3 rounded-xl border border-slate-200" id="contact-row-{{ $idx }}">
                            <div class="col-span-12 sm:col-span-4">
                                <input type="text" name="contacts[{{ $idx }}][type]" value="{{ $contact['type'] ?? '' }}" placeholder="e.g. Phone, Email, Hotline" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary">
                            </div>
                            <div class="col-span-10 sm:col-span-7">
                                <input type="text" name="contacts[{{ $idx }}][value]" value="{{ $contact['value'] ?? '' }}" placeholder="Value (e.g. +880 123456, info@domain.com)" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary">
                            </div>
                            <div class="col-span-2 sm:col-span-1 text-right">
                                <button type="button" onclick="document.getElementById('contact-row-{{ $idx }}').remove()" class="p-2 text-rose-400 hover:text-rose-600 rounded-lg transition-colors">
                                    <i class="ph-bold ph-x"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="grid grid-cols-12 gap-3 items-center bg-slate-50 p-3 rounded-xl border border-slate-200" id="contact-row-0">
                            <div class="col-span-12 sm:col-span-4">
                                <input type="text" name="contacts[0][type]" value="Phone" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary">
                            </div>
                            <div class="col-span-10 sm:col-span-7">
                                <input type="text" name="contacts[0][value]" value="+880 1234 567890" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary">
                            </div>
                            <div class="col-span-2 sm:col-span-1 text-right">
                                <button type="button" onclick="document.getElementById('contact-row-0').remove()" class="p-2 text-rose-400 hover:text-rose-600 rounded-lg transition-colors">
                                    <i class="ph-bold ph-x"></i>
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </x-admin.card>

            <!-- Card 3: Multiple Social Media Links -->
            <x-admin.card title="Social Media Channels" subtitle="Links to the university's public profiles." icon="ph-bold ph-share-network">
                <x-slot name="actions">
                    <x-admin.btn type="button" variant="navy-soft" size="sm" onclick="addSocialRow()">
                        <i class="ph-bold ph-plus text-xs"></i>
                        Add Channel
                    </x-admin.btn>
                </x-slot>

                <div id="socials-container" class="space-y-3">
                    @php
                        $socials = old('social_medias', $setting->social_medias ?: []);
                    @endphp
                    @forelse($socials as $idx => $social)
                        <div class="grid grid-cols-12 gap-3 items-center bg-slate-50 p-3 rounded-xl border border-slate-200" id="social-row-{{ $idx }}">
                            <div class="col-span-12 sm:col-span-4">
                                <input type="text" name="social_medias[{{ $idx }}][platform]" value="{{ $social['platform'] ?? '' }}" placeholder="e.g. Facebook, YouTube" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary">
                            </div>
                            <div class="col-span-10 sm:col-span-7">
                                <input type="url" name="social_medias[{{ $idx }}][url]" value="{{ $social['url'] ?? '' }}" placeholder="https://..." class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary">
                            </div>
                            <div class="col-span-2 sm:col-span-1 text-right">
                                <button type="button" onclick="document.getElementById('social-row-{{ $idx }}').remove()" class="p-2 text-rose-400 hover:text-rose-600 rounded-lg transition-colors">
                                    <i class="ph-bold ph-x"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="grid grid-cols-12 gap-3 items-center bg-slate-50 p-3 rounded-xl border border-slate-200" id="social-row-0">
                            <div class="col-span-12 sm:col-span-4">
                                <input type="text" name="social_medias[0][platform]" value="Facebook" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary">
                            </div>
                            <div class="col-span-10 sm:col-span-7">
                                <input type="url" name="social_medias[0][url]" value="https://facebook.com" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary">
                            </div>
                            <div class="col-span-2 sm:col-span-1 text-right">
                                <button type="button" onclick="document.getElementById('social-row-0').remove()" class="p-2 text-rose-400 hover:text-rose-600 rounded-lg transition-colors">
                                    <i class="ph-bold ph-x"></i>
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </x-admin.card>

            <!-- Card 4: SEO Settings -->
            <x-admin.card title="SEO & Meta Settings" subtitle="Search-engine metadata for the homepage." icon="ph-bold ph-magnifying-glass">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="meta_title" :value="__('Meta Title')" />
                        <x-text-input id="meta_title" class="block mt-1.5 w-full text-xs" type="text" name="meta_title" :value="old('meta_title', $setting->meta_title)" placeholder="e.g. Dhaka Global University | Center for Learning" />
                        <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="meta_author" :value="__('Meta Author')" />
                        <x-text-input id="meta_author" class="block mt-1.5 w-full text-xs" type="text" name="meta_author" :value="old('meta_author', $setting->meta_author)" placeholder="e.g. Dhaka Global University" />
                        <x-input-error :messages="$errors->get('meta_author')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-6">
                    <x-input-label for="meta_keywords" :value="__('Meta Keywords (Comma separated)')" />
                    <x-text-input id="meta_keywords" class="block mt-1.5 w-full text-xs" type="text" name="meta_keywords" :value="old('meta_keywords', $setting->meta_keywords)" placeholder="e.g. education, university, dhaka global university, admission" />
                    <x-input-error :messages="$errors->get('meta_keywords')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <x-input-label for="meta_description" :value="__('Meta Description')" />
                    <textarea id="meta_description" name="meta_description" rows="3" class="mt-1.5 block w-full border border-slate-300 focus:border-primary focus:ring-primary rounded-lg shadow-sm text-xs" placeholder="Describe your university for search engines...">{{ old('meta_description', $setting->meta_description) }}</textarea>
                    <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
                </div>
            </x-admin.card>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4">
                <x-admin.btn type="submit" variant="primary" size="lg">
                    <i class="ph-bold ph-floppy-disk text-sm"></i>
                    Save Settings
                </x-admin.btn>
            </div>
        </form>
    </div>

    <script>
        function addContactRow() {
            const container = document.getElementById('contacts-container');
            const idx = Date.now();
            const html = `
                <div class="grid grid-cols-12 gap-3 items-center bg-slate-50 p-3 rounded-xl border border-slate-200" id="contact-row-${idx}">
                    <div class="col-span-12 sm:col-span-4">
                        <input type="text" name="contacts[${idx}][type]" placeholder="e.g. Phone, Email, Hotline" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary">
                    </div>
                    <div class="col-span-10 sm:col-span-7">
                        <input type="text" name="contacts[${idx}][value]" placeholder="Value" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary">
                    </div>
                    <div class="col-span-2 sm:col-span-1 text-right">
                        <button type="button" onclick="document.getElementById('contact-row-${idx}').remove()" class="p-2 text-rose-400 hover:text-rose-600 rounded-lg transition-colors">
                            <i class="ph-bold ph-x"></i>
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
                <div class="grid grid-cols-12 gap-3 items-center bg-slate-50 p-3 rounded-xl border border-slate-200" id="social-row-${idx}">
                    <div class="col-span-12 sm:col-span-4">
                        <input type="text" name="social_medias[${idx}][platform]" placeholder="e.g. YouTube, Twitter" class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary">
                    </div>
                    <div class="col-span-10 sm:col-span-7">
                        <input type="url" name="social_medias[${idx}][url]" placeholder="https://..." class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-primary">
                    </div>
                    <div class="col-span-2 sm:col-span-1 text-right">
                        <button type="button" onclick="document.getElementById('social-row-${idx}').remove()" class="p-2 text-rose-400 hover:text-rose-600 rounded-lg transition-colors">
                            <i class="ph-bold ph-x"></i>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }
    </script>
</x-admin-layout>
