@php
    $uniSetting = \App\Models\UniversitySetting::first();
    $parentPages = \App\Models\Page::whereNull('parent_id')->orWhere('parent_id', 0)->orderBy('sort_order', 'asc')->get();
@endphp

<footer class="bg-primaryDark text-white pt-20 pb-6 border-t-4 border-secondary">
    <div class="container mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16 reveal-on-scroll">
            
            <!-- Col 1 -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    @if($uniSetting && $uniSetting->logo)
                        <img src="{{ asset($uniSetting->logo) }}" alt="Logo" class="h-12 object-contain bg-white p-1">
                    @else
                        <div class="w-12 h-12 bg-white flex items-center justify-center text-primary font-serif font-bold text-xl rounded-none">
                            @php
                                $words = explode(' ', $uniSetting->name ?? 'Dhaka Global University');
                                $initials = '';
                                foreach ($words as $w) {
                                    $initials .= strtoupper(substr($w, 0, 1));
                                }
                                echo e(substr($initials, 0, 2));
                            @endphp
                        </div>
                    @endif
                    <h2 class="text-xl font-serif font-bold text-white tracking-tight leading-none uppercase">
                        @if($uniSetting && $uniSetting->name)
                            {!! nl2br(e($uniSetting->name)) !!}
                        @else
                            Dhaka Global <br>University
                        @endif
                    </h2>
                </div>
                <p class="text-sm text-slate-400 mb-6 leading-relaxed" style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                    {{ strip_tags($uniSetting->meta_description ?? (\App\Models\HomepageSetting::first()->about_description ?? 'A center for quality education committed to nurturing excellence and ethical standards in higher education.')) }}
                </p>
                <div class="flex gap-2">
                    @if($uniSetting && $uniSetting->social_medias)
                        @foreach($uniSetting->social_medias as $social)
                            @php
                                $icon = 'ph-fill ph-link';
                                $platform = strtolower($social['platform'] ?? '');
                                if (str_contains($platform, 'facebook')) $icon = 'ph-fill ph-facebook-logo';
                                elseif (str_contains($platform, 'twitter') || str_contains($platform, 'x')) $icon = 'ph-fill ph-x-logo';
                                elseif (str_contains($platform, 'linkedin')) $icon = 'ph-fill ph-linkedin-logo';
                                elseif (str_contains($platform, 'youtube')) $icon = 'ph-fill ph-youtube-logo';
                                elseif (str_contains($platform, 'instagram')) $icon = 'ph-fill ph-instagram-logo';
                            @endphp
                            @if(!empty($social['url']))
                                <a href="{{ $social['url'] }}" target="_blank" class="w-9 h-9 bg-primary flex items-center justify-center hover:bg-secondary transition text-white">
                                    <i class="{{ $icon }}"></i>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Col 2 -->
            <div>
                <h3 class="text-white text-lg font-serif font-bold mb-6 border-l-2 border-secondary pl-3">Quick Links</h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    @foreach($parentPages as $pPage)
                        <li>
                            <a href="{{ route('page.show', $pPage->slug) }}" class="hover:text-secondary transition flex items-center gap-2">
                                <i class="ph-bold ph-caret-right text-secondary"></i> {{ $pPage->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Col 3: Contact Info -->
            <div>
                <h3 class="text-white text-lg font-serif font-bold mb-6 border-l-2 border-secondary pl-3">Contact Info</h3>
                <ul class="space-y-4 text-sm text-slate-400">
                    @if($uniSetting && $uniSetting->address)
                        <li class="flex items-start gap-3">
                            <i class="ph-fill ph-map-pin text-secondary mt-1 text-lg"></i>
                            <span>{!! nl2br(e($uniSetting->address)) !!}</span>
                        </li>
                    @endif
                    @if($uniSetting && $uniSetting->contacts)
                        @foreach($uniSetting->contacts as $contact)
                            @if(!empty($contact['value']))
                                <li class="flex items-start gap-3">
                                    @php
                                        $type = strtolower($contact['type'] ?? '');
                                        $icon = 'ph-fill ph-info';
                                        $href = null;
                                        if (str_contains($type, 'phone') || str_contains($type, 'call') || str_contains($type, 'mobile')) {
                                            $icon = 'ph-fill ph-phone-call';
                                            $href = 'tel:' . $contact['value'];
                                        } elseif (str_contains($type, 'email') || str_contains($type, 'mail')) {
                                            $icon = 'ph-fill ph-envelope-simple';
                                            $href = 'mailto:' . $contact['value'];
                                        }
                                    @endphp
                                    <i class="{{ $icon }} text-secondary mt-1 text-lg"></i>
                                    @if($href)
                                        <a href="{{ $href }}" class="hover:text-white transition break-all">{{ $contact['value'] }}</a>
                                    @else
                                        <span>{{ $contact['value'] }}</span>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row justify-between items-center text-xs text-slate-500">
            <p>&copy; <span id="current-year"></span> {{ $uniSetting->name ?? 'Feni University' }}. All Rights Reserved.</p>
            <p class="mt-2 md:mt-0">Developed by <a href="https://www.vidatech.com.bd/" target="_blank" class="text-secondary hover:text-white transition font-bold">Vida Technology</a></p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Set current year
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Mobile Menu Toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = menuBtn.querySelector('i');
        
        if (menuBtn && mobileMenu && menuIcon) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                if(mobileMenu.classList.contains('hidden')){
                    menuIcon.classList.replace('ph-x', 'ph-list');
                } else {
                    menuIcon.classList.replace('ph-list', 'ph-x');
                }
            });
        }

        // Swiper Initialization
        const swiperEl = document.querySelector('.heroSwiper');
        if (swiperEl) {
            new Swiper('.heroSwiper', {
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                loop: true,
                autoplay: { delay: 5000, disableOnInteraction: false },
                speed: 800,
                navigation: {
                    nextEl: '.hero-next',
                    prevEl: '.hero-prev',
                },
            });
        }

        // Fallback for browsers without CSS animation-timeline support (like Safari)
        if (!CSS.supports('animation-timeline: view()')) {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15
            };
            
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));
        }
    });
</script>
