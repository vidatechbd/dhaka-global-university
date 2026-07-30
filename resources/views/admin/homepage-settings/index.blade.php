<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-gray-800">{{ __('Homepage Settings') }}</h1>
    </x-slot>

    <div x-data="{ activeTab: 'topbar' }" class="space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-xs font-medium rounded-r-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tab Navigation Buttons -->
        <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-px">
            <button @click="activeTab = 'topbar'" :class="activeTab === 'topbar' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-4 py-2 border-b-2 text-xs uppercase tracking-wider font-semibold transition-all">
                Top Bar Settings
            </button>
            <button @click="activeTab = 'hero'" :class="activeTab === 'hero' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-4 py-2 border-b-2 text-xs uppercase tracking-wider font-semibold transition-all">
                Hero Section
            </button>
            <button @click="activeTab = 'about'" :class="activeTab === 'about' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-4 py-2 border-b-2 text-xs uppercase tracking-wider font-semibold transition-all">
                About Section
            </button>
            <button @click="activeTab = 'leadership'" :class="activeTab === 'leadership' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-4 py-2 border-b-2 text-xs uppercase tracking-wider font-semibold transition-all">
                Leadership
            </button>
            <button @click="activeTab = 'faculties'" :class="activeTab === 'faculties' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-4 py-2 border-b-2 text-xs uppercase tracking-wider font-semibold transition-all">
                Faculties
            </button>
            <button @click="activeTab = 'visibility'" :class="activeTab === 'visibility' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-4 py-2 border-b-2 text-xs uppercase tracking-wider font-semibold transition-all">
                Visibility Toggles
            </button>
        </div>

        <!-- Main Form -->
        <form action="{{ route('admin.homepage-settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-300 p-6 space-y-6">
            @csrf

            <!-- ================= TOP BAR SECTION ================= -->
            <div x-show="activeTab === 'topbar'" class="space-y-6" x-data="{ 
                links: {{ json_encode($setting->top_bar_links ?? []) }},
                addLink() { this.links.push({ title: '', url: '' }); },
                removeLink(index) { this.links.splice(index, 1); }
            }">
                <div class="border-b border-gray-200 pb-3">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Top Header Bar</h3>
                    <p class="text-xs text-gray-500 mt-1">Manage the top-most contacts bar on the website (phone, email, custom links).</p>
                </div>

                <div class="space-y-4">
                    <label class="flex items-center gap-3 p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer w-max">
                        <input type="checkbox" name="show_top_bar" value="1" {{ $setting->show_top_bar ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-700">Show Top Bar</span>
                            <span class="text-[10px] text-gray-400">Toggle whether this top bar is displayed.</span>
                        </div>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="top_bar_email" :value="__('Top Bar Email')" />
                        <x-text-input id="top_bar_email" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white" type="email" name="top_bar_email" :value="old('top_bar_email', $setting->top_bar_email)" placeholder="registrar@feniuniversity.ac.bd" />
                    </div>
                    <div>
                        <x-input-label for="top_bar_phone" :value="__('Top Bar Phone')" />
                        <x-text-input id="top_bar_phone" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white" type="text" name="top_bar_phone" :value="old('top_bar_phone', $setting->top_bar_phone)" placeholder="02334474194" />
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <x-input-label :value="__('Top Bar Navigation Links')" />
                        <button type="button" @click="addLink()" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded text-[10px] uppercase transition shadow-sm">
                            + Add Link
                        </button>
                    </div>
                    
                    <div class="space-y-3">
                        <template x-for="(link, index) in links" :key="index">
                            <div class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-md">
                                <div class="grid grid-cols-2 gap-3 flex-grow">
                                    <div>
                                        <input type="text" :name="'top_bar_links[' + index + '][title]'" x-model="link.title" class="w-full text-xs border border-gray-300 rounded px-2.5 py-1.5 outline-none bg-white" placeholder="Link Title (e.g. Career)" required>
                                    </div>
                                    <div>
                                        <input type="text" :name="'top_bar_links[' + index + '][url]'" x-model="link.url" class="w-full text-xs border border-gray-300 rounded px-2.5 py-1.5 outline-none bg-white" placeholder="Link URL (e.g. /career)" required>
                                    </div>
                                </div>
                                <button type="button" @click="removeLink(index)" class="text-red-500 hover:text-red-700 p-1 flex items-center justify-center">
                                    <i class="ph ph-trash text-lg"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- ================= HERO SECTION ================= -->
            <div x-show="activeTab === 'hero'" class="space-y-6" x-data="{
                slides: {{ json_encode($setting->hero_slides ?? []) }},
                addSlide() {
                    this.slides.push({
                        image: '',
                        tag: '',
                        title: '',
                        description: '',
                        btn_text_1: '',
                        btn_url_1: '',
                        btn_text_2: '',
                        btn_url_2: ''
                    });
                },
                removeSlide(index) {
                    this.slides.splice(index, 1);
                }
            }">
                <div class="border-b border-gray-200 pb-3 flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Dynamic Hero Slides</h3>
                        <p class="text-xs text-gray-500 mt-1">Manage slides. Each slide can have its own image, tag, title, description, and custom overlay buttons.</p>
                    </div>
                    <button type="button" @click="addSlide()" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded text-[10px] uppercase transition shadow-sm">
                        + Add Slide
                    </button>
                </div>

                <div class="space-y-6">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div class="p-5 border border-gray-300 rounded-lg bg-gray-50 space-y-4 relative shadow-sm">
                            <div class="absolute top-4 right-4 flex items-center gap-2">
                                <span class="bg-gray-200 text-gray-800 text-[10px] font-bold px-2 py-0.5 rounded">
                                    Slide <span x-text="index + 1"></span>
                                </span>
                                <button type="button" @click="removeSlide(index)" class="bg-red-500 hover:bg-red-600 text-white p-1 rounded transition flex items-center justify-center">
                                    <i class="ph ph-trash text-xs"></i>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 pt-4">
                                <!-- Image Upload & Preview -->
                                <div class="md:col-span-4 space-y-2">
                                    <x-input-label :value="__('Slide Image')" />
                                    <!-- Keep track of existing image path -->
                                    <input type="hidden" :name="'slides[' + index + '][existing_image]'" :value="slide.image">
                                    
                                    <input type="file" :name="'slides[' + index + '][image]'" class="block w-full border border-gray-300 rounded p-1.5 text-[10px] bg-white" accept="image/*">
                                    
                                    <template x-if="slide.image">
                                        <div class="mt-2 border border-gray-300 rounded overflow-hidden h-28 bg-black">
                                            <img :src="slide.image.startsWith('http') ? slide.image : '/' + slide.image" class="w-full h-full object-cover">
                                        </div>
                                    </template>
                                    <template x-if="!slide.image">
                                        <div class="mt-2 border border-dashed border-gray-300 rounded flex items-center justify-center h-28 bg-white text-gray-400 text-xs">
                                            <span>No Image Selected</span>
                                        </div>
                                    </template>
                                </div>

                                <!-- Text Content fields -->
                                <div class="md:col-span-8 space-y-3">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <x-input-label :value="__('Slide Tag')" />
                                            <input type="text" :name="'slides[' + index + '][tag]'" x-model="slide.tag" class="w-full text-xs border border-gray-300 rounded px-2.5 py-1.5 bg-white outline-none" placeholder="e.g. Fall Admissions Open">
                                        </div>
                                        <div>
                                            <x-input-label :value="__('Slide Title')" />
                                            <input type="text" :name="'slides[' + index + '][title]'" x-model="slide.title" class="w-full text-xs border border-gray-300 rounded px-2.5 py-1.5 bg-white outline-none" placeholder="e.g. Empowering Minds...">
                                        </div>
                                    </div>

                                    <div>
                                        <x-input-label :value="__('Slide Description')" />
                                        <textarea :name="'slides[' + index + '][description]'" x-model="slide.description" rows="2" class="w-full text-xs border border-gray-300 rounded p-2 bg-white outline-none" placeholder="Enter slide description text..."></textarea>
                                    </div>

                                    <!-- Button Configs -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="p-3 border border-gray-200 rounded bg-white space-y-2">
                                            <span class="text-[10px] font-bold text-gray-500 uppercase">Button 1</span>
                                            <input type="text" :name="'slides[' + index + '][btn_text_1]'" x-model="slide.btn_text_1" class="w-full text-[10px] border border-gray-300 rounded px-2 py-1 outline-none" placeholder="Text (e.g. Explore)">
                                            <input type="text" :name="'slides[' + index + '][btn_url_1]'" x-model="slide.btn_url_1" class="w-full text-[10px] border border-gray-300 rounded px-2 py-1 outline-none mt-1" placeholder="Link URL (e.g. #)">
                                        </div>
                                        <div class="p-3 border border-gray-200 rounded bg-white space-y-2">
                                            <span class="text-[10px] font-bold text-gray-500 uppercase">Button 2</span>
                                            <input type="text" :name="'slides[' + index + '][btn_text_2]'" x-model="slide.btn_text_2" class="w-full text-[10px] border border-gray-300 rounded px-2 py-1 outline-none" placeholder="Text (e.g. Tour)">
                                            <input type="text" :name="'slides[' + index + '][btn_url_2]'" x-model="slide.btn_url_2" class="w-full text-[10px] border border-gray-300 rounded px-2 py-1 outline-none mt-1" placeholder="Link URL (e.g. #)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <template x-if="slides.length === 0">
                        <div class="p-10 border-2 border-dashed border-gray-300 rounded-lg text-center text-gray-400 text-xs">
                            No slides configured. Click "+ Add Slide" to create one.
                        </div>
                    </template>
                </div>
            </div>

            <!-- ================= ABOUT SECTION ================= -->
            <div x-show="activeTab === 'about'" class="space-y-6">
                <div class="border-b border-gray-200 pb-3">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">About Section</h3>
                    <p class="text-xs text-gray-500 mt-1">Manage the core welcome/about section of the landing page.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <x-input-label for="about_tag" :value="__('About Tag')" />
                        <x-text-input id="about_tag" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" name="about_tag" :value="old('about_tag', $setting->about_tag)" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="about_title" :value="__('About Title')" />
                        <x-text-input id="about_title" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" name="about_title" :value="old('about_title', $setting->about_title)" />
                    </div>
                </div>

                <div>
                    <x-input-label for="about_description" :value="__('About Description')" />
                    <textarea id="about_description" name="about_description" rows="5" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 text-xs">{{ old('about_description', $setting->about_description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="about_years" :value="__('Years of Excellence')" />
                        <x-text-input id="about_years" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" name="about_years" :value="old('about_years', $setting->about_years)" placeholder="e.g. 11+" />
                    </div>
                    <div>
                        <x-input-label for="about_url" :value="__('Read More Link')" />
                        <x-text-input id="about_url" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" name="about_url" :value="old('about_url', $setting->about_url)" />
                    </div>
                </div>

                <div>
                    <x-input-label for="about_image" :value="__('About Image')" />
                    <input id="about_image" type="file" name="about_image" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-xs" accept="image/*">
                    @if($setting->about_image)
                        <div class="mt-2">
                            <img src="{{ Str::startsWith($setting->about_image, 'http') ? $setting->about_image : asset($setting->about_image) }}" class="h-32 object-cover rounded border border-gray-300 p-1">
                        </div>
                    @endif
                </div>
            </div>

            <!-- ================= LEADERSHIP SECTION ================= -->
            <div x-show="activeTab === 'leadership'" class="space-y-6" x-data="{
                members: {{ json_encode($setting->leadership_members ?? []) }},
                addMember() { this.members.push({ name: '', designation: '', image: '', message_url: '#' }); },
                removeMember(index) { this.members.splice(index, 1); }
            }">
                <div class="border-b border-gray-200 pb-3 flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Leadership & Authorities</h3>
                        <p class="text-xs text-gray-500 mt-1">Manage titles and the list of leadership authority members dynamically.</p>
                    </div>
                    <button type="button" @click="addMember()" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded text-[10px] uppercase transition shadow-sm">
                        + Add Member
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="leadership_title" :value="__('Section Title')" />
                        <x-text-input id="leadership_title" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" name="leadership_title" :value="old('leadership_title', $setting->leadership_title)" />
                    </div>
                    <div>
                        <x-input-label for="leadership_description" :value="__('Section Description')" />
                        <x-text-input id="leadership_description" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" name="leadership_description" :value="old('leadership_description', $setting->leadership_description)" />
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider border-b pb-1">Members List</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <template x-for="(member, index) in members" :key="index">
                            <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 space-y-3 relative">
                                <div class="absolute top-4 right-4 flex items-center gap-2">
                                    <span class="bg-gray-200 text-gray-800 text-[10px] font-bold px-2 py-0.5 rounded">
                                        Member <span x-text="index + 1"></span>
                                    </span>
                                    <button type="button" @click="removeMember(index)" class="bg-red-500 hover:bg-red-600 text-white p-1 rounded transition flex items-center justify-center">
                                        <i class="ph ph-trash text-xs"></i>
                                    </button>
                                </div>
                                
                                <input type="hidden" :name="'leadership_members[' + index + '][existing_image]'" :value="member.image">
                                
                                <div class="pt-4">
                                    <x-input-label :value="__('Name')" />
                                    <input type="text" :name="'leadership_members[' + index + '][name]'" x-model="member.name" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white text-xs outline-none" required>
                                </div>
                                
                                <div>
                                    <x-input-label :value="__('Designation')" />
                                    <input type="text" :name="'leadership_members[' + index + '][designation]'" x-model="member.designation" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white text-xs outline-none">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label :value="__('Message / Profile Link')" />
                                        <input type="text" :name="'leadership_members[' + index + '][message_url]'" x-model="member.message_url" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white text-xs outline-none">
                                    </div>
                                    <div>
                                        <x-input-label :value="__('Profile Photo')" />
                                        <input type="file" :name="'leadership_members[' + index + '][image]'" class="block mt-1 w-full border border-gray-300 rounded-md p-1 bg-white text-[10px]" accept="image/*">
                                    </div>
                                </div>

                                <template x-if="member.image">
                                    <div class="mt-2 flex items-center gap-2">
                                        <img :src="member.image.startsWith('http') ? member.image : '/' + member.image" class="w-10 h-10 object-cover rounded-full border border-gray-300 p-0.5 animate-fade-in">
                                        <span class="text-[10px] text-gray-500">Current Photo</span>
                                    </div>
                                </template>
                            </div>
                        </template>
                        
                        <template x-if="members.length === 0">
                            <div class="col-span-2 p-8 border-2 border-dashed border-gray-300 rounded-lg text-center text-gray-400 text-xs">
                                No leadership members configured. Click "+ Add Member" to add one.
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- ================= FACULTIES SECTION ================= -->
            <div x-show="activeTab === 'faculties'" class="space-y-6" x-data="{
                faculties: {{ json_encode($setting->faculties ?? []) }},
                addFaculty() { this.faculties.push({ name: '', explore_url: '#', image: '', depts: '' }); },
                removeFaculty(index) { this.faculties.splice(index, 1); }
            }">
                <div class="border-b border-gray-200 pb-3 flex justify-between items-center">
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Academic Faculties</h3>
                        <p class="text-xs text-gray-500 mt-1">Manage titles and the list of academic faculties dynamically.</p>
                    </div>
                    <button type="button" @click="addFaculty()" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded text-[10px] uppercase transition shadow-sm">
                        + Add Faculty
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <x-input-label for="faculties_title" :value="__('Faculties Title')" />
                        <x-text-input id="faculties_title" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" name="faculties_title" :value="old('faculties_title', $setting->faculties_title)" />
                    </div>
                    <div>
                        <x-input-label for="faculties_btn_text" :value="__('View All Button Text')" />
                        <x-text-input id="faculties_btn_text" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" name="faculties_btn_text" :value="old('faculties_btn_text', $setting->faculties_btn_text)" />
                    </div>
                    <div>
                        <x-input-label for="faculties_btn_url" :value="__('View All Button URL')" />
                        <x-text-input id="faculties_btn_url" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2" type="text" name="faculties_btn_url" :value="old('faculties_btn_url', $setting->faculties_btn_url)" />
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider border-b pb-1">Faculties List</h4>

                    <div class="space-y-4">
                        <template x-for="(faculty, index) in faculties" :key="index">
                            <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 grid grid-cols-1 md:grid-cols-2 gap-4 relative">
                                <div class="absolute top-4 right-4 flex items-center gap-2">
                                    <span class="bg-gray-200 text-gray-800 text-[10px] font-bold px-2 py-0.5 rounded">
                                        Faculty <span x-text="index + 1"></span>
                                    </span>
                                    <button type="button" @click="removeFaculty(index)" class="bg-red-500 hover:bg-red-600 text-white p-1 rounded transition flex items-center justify-center">
                                        <i class="ph ph-trash text-xs"></i>
                                    </button>
                                </div>

                                <input type="hidden" :name="'faculties[' + index + '][existing_image]'" :value="faculty.image">

                                <div class="space-y-3 pt-4">
                                    <div>
                                        <x-input-label :value="__('Faculty Name')" />
                                        <input type="text" :name="'faculties[' + index + '][name]'" x-model="faculty.name" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white text-xs outline-none" required>
                                    </div>
                                    <div>
                                        <x-input-label :value="__('Explore Link')" />
                                        <input type="text" :name="'faculties[' + index + '][explore_url]'" x-model="faculty.explore_url" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white text-xs outline-none">
                                    </div>
                                </div>
                                <div class="space-y-3 pt-4">
                                    <div>
                                        <x-input-label :value="__('Cover Image')" />
                                        <input type="file" :name="'faculties[' + index + '][image]'" class="block mt-1 w-full border border-gray-300 rounded-md p-1 bg-white text-[10px]" accept="image/*">
                                        
                                        <template x-if="faculty.image">
                                            <div class="mt-2 flex items-center gap-2">
                                                <img :src="faculty.image.startsWith('http') ? faculty.image : '/' + faculty.image" class="w-16 h-10 object-cover rounded border border-gray-300 p-0.5">
                                                <span class="text-[10px] text-gray-500">Current Cover</span>
                                            </div>
                                        </template>
                                    </div>
                                    <div>
                                        <x-input-label :value="__('Departments (Comma-separated)')" />
                                        <input type="text" :name="'faculties[' + index + '][depts]'" :value="Array.isArray(faculty.depts) ? faculty.depts.join(', ') : faculty.depts" @input="faculty.depts = $event.target.value" class="block mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-white text-xs outline-none" placeholder="e.g. Dept. of CSE, Dept. of EEE">
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template x-if="faculties.length === 0">
                            <div class="p-8 border-2 border-dashed border-gray-300 rounded-lg text-center text-gray-400 text-xs">
                                No faculties configured. Click "+ Add Faculty" to add one.
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- ================= VISIBILITY TOGGLES ================= -->
            <div x-show="activeTab === 'visibility'" class="space-y-6">
                <div class="border-b border-gray-200 pb-3">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Visibility Toggles</h3>
                    <p class="text-xs text-gray-500 mt-1">Show or hide specific homepage sections directly from here.</p>
                </div>

                <div class="space-y-4 max-w-md">
                    <label class="flex items-center justify-between p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-700">Hero Section</span>
                            <span class="text-[10px] text-gray-400">Toggle slider banner visibility.</span>
                        </div>
                        <input type="checkbox" name="show_hero" value="1" {{ $setting->show_hero ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500">
                    </label>

                    <label class="flex items-center justify-between p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-700">About Section</span>
                            <span class="text-[10px] text-gray-400">Toggle welcoming details.</span>
                        </div>
                        <input type="checkbox" name="show_about" value="1" {{ $setting->show_about ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500">
                    </label>

                    <label class="flex items-center justify-between p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-700">Leadership Board</span>
                            <span class="text-[10px] text-gray-400">Toggle university leaders display.</span>
                        </div>
                        <input type="checkbox" name="show_leadership" value="1" {{ $setting->show_leadership ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500">
                    </label>

                    <label class="flex items-center justify-between p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-700">Academic Faculties</span>
                            <span class="text-[10px] text-gray-400">Toggle programs and faculties layout.</span>
                        </div>
                        <input type="checkbox" name="show_faculties" value="1" {{ $setting->show_faculties ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500">
                    </label>

                    <label class="flex items-center justify-between p-3 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-700">News & Notices Section</span>
                            <span class="text-[10px] text-gray-400">Toggle campus news & notices board.</span>
                        </div>
                        <input type="checkbox" name="show_news_notice" value="1" {{ $setting->show_news_notice ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500">
                    </label>
                </div>
            </div>

            <!-- Submit Button (Sticky/Fixed style inside form) -->
            <div class="flex justify-end pt-4 border-t border-gray-300">
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-md shadow-sm transition">
                    Save All Settings
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
