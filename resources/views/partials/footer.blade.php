<footer class="bg-primaryDark text-white pt-20 pb-6 border-t-4 border-secondary">
    <div class="container mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16 reveal-on-scroll">
            
            <!-- Col 1 -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-white flex items-center justify-center text-primary font-serif font-bold text-xl rounded-none">
                        FU
                    </div>
                    <h2 class="text-xl font-serif font-bold text-white tracking-tight leading-none uppercase">Feni <br>University</h2>
                </div>
                <p class="text-sm text-slate-400 mb-6 leading-relaxed">
                    A center for quality education committed to nurturing excellence and ethical standards in higher education.
                </p>
                <div class="flex gap-2">
                    <a href="#" class="w-9 h-9 bg-primary flex items-center justify-center hover:bg-secondary transition"><i class="ph-fill ph-facebook-logo"></i></a>
                    <a href="#" class="w-9 h-9 bg-primary flex items-center justify-center hover:bg-secondary transition"><i class="ph-fill ph-twitter-logo"></i></a>
                    <a href="#" class="w-9 h-9 bg-primary flex items-center justify-center hover:bg-secondary transition"><i class="ph-fill ph-linkedin-logo"></i></a>
                    <a href="#" class="w-9 h-9 bg-primary flex items-center justify-center hover:bg-secondary transition"><i class="ph-fill ph-youtube-logo"></i></a>
                </div>
            </div>

            <!-- Col 2 -->
            <div>
                <h3 class="text-white text-lg font-serif font-bold mb-6 border-l-2 border-secondary pl-3">Quick Links</h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> IQAC</a></li>
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Facilities</a></li>
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Permanent Campus</a></li>
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Career Opportunities</a></li>
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Forms & Downloads</a></li>
                </ul>
            </div>

            <!-- Col 3 -->
            <div>
                <h3 class="text-white text-lg font-serif font-bold mb-6 border-l-2 border-secondary pl-3">Student Hub</h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Adviser Office</a></li>
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Proctor Office</a></li>
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Alumni Network</a></li>
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Central Library</a></li>
                    <li><a href="#" class="hover:text-secondary transition flex items-center gap-2"><i class="ph-bold ph-caret-right text-secondary"></i> Student Clubs</a></li>
                </ul>
            </div>

            <!-- Col 4 -->
            <div>
                <h3 class="text-white text-lg font-serif font-bold mb-6 border-l-2 border-secondary pl-3">Contact Info</h3>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li class="flex items-start gap-3">
                        <i class="ph-fill ph-map-pin text-secondary mt-1 text-lg"></i>
                        <span>Trunk Road, Feni-3900,<br> Bangladesh</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="ph-fill ph-phone-call text-secondary mt-1 text-lg"></i>
                        <a href="tel:02334474194" class="hover:text-white transition">02334474194</a>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="ph-fill ph-envelope-simple text-secondary mt-1 text-lg"></i>
                        <a href="mailto:registrar@feniuniversity.ac.bd" class="hover:text-white transition break-all">registrar@feniuniversity.ac.bd</a>
                    </li>
                </ul>
            </div>
        </div>

        @php
            $uniSetting = \App\Models\UniversitySetting::first();
        @endphp
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
