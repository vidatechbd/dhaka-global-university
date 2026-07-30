<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dhaka Global University') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            100: '#B5D3D2',
                            200: '#98b5b4',
                            300: '#587372',
                        },
                        accent: {
                            100: '#FFB6C1',
                            200: '#985863',
                        },
                        textclr: {
                            100: '#4C4C4C',
                            200: '#787878',
                        },
                        bgclr: {
                            100: '#F0E8EE',
                            200: '#e6dee4',
                            300: '#bdb6bc',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for a cleaner look */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #bdb6bc;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #98b5b4;
        }

        #sidebar.w-20 .nav-link {
            padding-left: 0;
            padding-right: 0;
            justify-content: center;
        }
    </style>
</head>
<body class="bg-bgclr-100 font-sans flex h-screen overflow-hidden text-textclr-100">

    <!-- Sidebar -->
    <aside 
        id="sidebar" 
        class="w-64 bg-bgclr-200 border-r border-bgclr-300 flex flex-col transition-all duration-300 ease-in-out shrink-0 relative shadow-[4px_0_24px_rgba(0,0,0,0.02)]"
    >
        <!-- Header -->
        <div id="sidebar-header" class="h-16 flex items-center justify-between px-4 border-b border-bgclr-300 shrink-0 transition-all duration-300">
            <!-- Brand / Logo -->
            <div class="flex items-center gap-3 sidebar-text overflow-hidden transition-opacity duration-200">
                <div class="w-8 h-8 bg-primary-200 rounded-lg flex items-center justify-center shrink-0 shadow-md shadow-primary-200/20">
                    <span class="text-white text-base">🎓</span>
                </div>
                <span class="font-bold text-sm whitespace-nowrap tracking-tight text-textclr-100 font-sans">Dhaka Global Uni</span>
            </div>
            
            <!-- Toggle Button -->
            <button id="toggle-btn" class="p-2 rounded-xl hover:bg-bgclr-300/40 text-textclr-200 hover:text-textclr-100 focus:outline-none transition-colors shrink-0 group">
                <svg class="w-5 h-5 transition-transform duration-300 group-active:scale-95" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 py-4 overflow-y-auto overflow-x-hidden">
            <ul class="space-y-1 px-3">
                
                <li class="px-2 mb-2 sidebar-text transition-opacity duration-200">
                    <span class="text-xs font-semibold text-textclr-200 uppercase tracking-wider">Main</span>
                </li>

                <!-- Nav Item: Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-link flex items-center px-3 py-2.5 rounded-xl group transition-all duration-200 relative {{ request()->routeIs('dashboard') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:bg-bgclr-300/20 hover:text-textclr-100' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-textclr-200 group-hover:text-textclr-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="sidebar-text ml-3 font-semibold whitespace-nowrap transition-opacity duration-200">Dashboard</span>
                        @if(request()->routeIs('dashboard'))
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-primary-300 rounded-r-full"></div>
                        @endif
                    </a>
                </li>

                <!-- Nav Item: Certificates (WITH SUBMENU) -->
                <li>
                    <button class="nav-link w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-200 submenu-toggle focus:outline-none {{ request()->routeIs('certificates.*') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:bg-bgclr-300/20 hover:text-textclr-100' }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('certificates.*') ? 'text-white' : 'text-textclr-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="sidebar-text ml-3 font-semibold whitespace-nowrap transition-opacity duration-200">Certificates</span>
                        </div>
                        <!-- Chevron Icon -->
                        <svg class="w-4 h-4 shrink-0 transition-transform duration-200 sidebar-text chevron-icon {{ request()->routeIs('certificates.*') ? 'rotate-180 text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Submenu Wrapper -->
                    <div class="sidebar-text transition-opacity duration-200">
                        <ul class="submenu-content space-y-1 mt-1 {{ request()->routeIs('certificates.*') ? '' : 'hidden' }}">
                            <li>
                                <a href="{{ route('certificates.index') }}" class="flex items-center pl-11 pr-3 py-2 text-sm font-semibold rounded-xl transition-colors {{ request()->routeIs('certificates.index') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:text-textclr-100 hover:bg-bgclr-300/20' }}">
                                    All certificates
                                </a>
                            </li>
                            @can('create certificate')
                                <li>
                                    <a href="{{ route('certificates.create') }}" class="flex items-center pl-11 pr-3 py-2 text-sm font-semibold rounded-xl transition-colors {{ request()->routeIs('certificates.create') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:text-textclr-100 hover:bg-bgclr-300/20' }}">
                                        Generate certificate
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>

                <!-- Role & Permission Management (WITH SUBMENU - Principal only) -->
                @role('Principal')
                    <li>
                        <button class="nav-link w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-200 submenu-toggle focus:outline-none {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:bg-bgclr-300/20 hover:text-textclr-100' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'text-white' : 'text-textclr-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span class="sidebar-text ml-3 font-semibold whitespace-nowrap transition-opacity duration-200">Permissions</span>
                            </div>
                            <!-- Chevron Icon -->
                            <svg class="w-4 h-4 shrink-0 transition-transform duration-200 sidebar-text chevron-icon {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'rotate-180 text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Submenu Wrapper -->
                        <div class="sidebar-text transition-opacity duration-200">
                            <ul class="submenu-content space-y-1 mt-1 {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.permissions.index') }}" class="flex items-center pl-11 pr-3 py-2 text-sm font-semibold rounded-xl transition-colors {{ request()->routeIs('admin.permissions.*') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:text-textclr-100 hover:bg-bgclr-300/20' }}">
                                        Permissions
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.roles.index') }}" class="flex items-center pl-11 pr-3 py-2 text-sm font-semibold rounded-xl transition-colors {{ request()->routeIs('admin.roles.index') || request()->routeIs('admin.roles.edit') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:text-textclr-100 hover:bg-bgclr-300/20' }}">
                                        Roles
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.roles.create') }}" class="flex items-center pl-11 pr-3 py-2 text-sm font-semibold rounded-xl transition-colors {{ request()->routeIs('admin.roles.create') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:text-textclr-100 hover:bg-bgclr-300/20' }}">
                                        Roles Create
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endrole
                <!-- Teachers Management (WITH SUBMENU - Principal only) -->
                @role('Principal')
                    <li>
                        <button class="nav-link w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-200 submenu-toggle focus:outline-none {{ request()->routeIs('admin.teachers.*') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:bg-bgclr-300/20 hover:text-textclr-100' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.teachers.*') ? 'text-white' : 'text-textclr-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                </svg>
                                <span class="sidebar-text ml-3 font-semibold whitespace-nowrap transition-opacity duration-200">Teachers</span>
                            </div>
                            <!-- Chevron Icon -->
                            <svg class="w-4 h-4 shrink-0 transition-transform duration-200 sidebar-text chevron-icon {{ request()->routeIs('admin.teachers.*') ? 'rotate-180 text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Submenu Wrapper -->
                        <div class="sidebar-text transition-opacity duration-200">
                            <ul class="submenu-content space-y-1 mt-1 {{ request()->routeIs('admin.teachers.*') ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.teachers.index') }}" class="flex items-center pl-11 pr-3 py-2 text-sm font-semibold rounded-xl transition-colors {{ request()->routeIs('admin.teachers.index') && !request()->query('action') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:text-textclr-100 hover:bg-bgclr-300/20' }}">
                                        All teachers
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.teachers.index') }}?action=create" class="flex items-center pl-11 pr-3 py-2 text-sm font-semibold rounded-xl transition-colors {{ request()->query('action') === 'create' && request()->routeIs('admin.teachers.index') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:text-textclr-100 hover:bg-bgclr-300/20' }}">
                                        Create teacher
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endrole

                <!-- Students Management (WITH SUBMENU - Principal/Teacher only) -->
                @can('manage students')
                    <li>
                        <button class="nav-link w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-200 submenu-toggle focus:outline-none {{ request()->routeIs('admin.students.*') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:bg-bgclr-300/20 hover:text-textclr-100' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.students.*') ? 'text-white' : 'text-textclr-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="sidebar-text ml-3 font-semibold whitespace-nowrap transition-opacity duration-200">Students</span>
                            </div>
                            <!-- Chevron Icon -->
                            <svg class="w-4 h-4 shrink-0 transition-transform duration-200 sidebar-text chevron-icon {{ request()->routeIs('admin.students.*') ? 'rotate-180 text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Submenu Wrapper -->
                        <div class="sidebar-text transition-opacity duration-200">
                            <ul class="submenu-content space-y-1 mt-1 {{ request()->routeIs('admin.students.*') ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.students.index') }}" class="flex items-center pl-11 pr-3 py-2 text-sm font-semibold rounded-xl transition-colors {{ request()->routeIs('admin.students.index') && !request()->query('action') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:text-textclr-100 hover:bg-bgclr-300/20' }}">
                                        All students
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.students.index') }}?action=create" class="flex items-center pl-11 pr-3 py-2 text-sm font-semibold rounded-xl transition-colors {{ request()->query('action') === 'create' && request()->routeIs('admin.students.index') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:text-textclr-100 hover:bg-bgclr-300/20' }}">
                                        Create student
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                <!-- News Management (WITH SUBMENU - Principal/Teacher only) -->
                @can('manage news')
                    <li>
                        <button class="nav-link w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-200 submenu-toggle focus:outline-none {{ request()->routeIs('admin.news.*') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:bg-bgclr-300/20 hover:text-textclr-100' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.news.*') ? 'text-white' : 'text-textclr-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 00-2-2m2 2a2 2 0 110 4m0 0H8m12 0a2 2 0 012 2v2a2 2 0 01-2 2H8m12 0a2 2 0 01-2-2v-2"></path>
                                </svg>
                                <span class="sidebar-text ml-3 font-semibold whitespace-nowrap transition-opacity duration-200">News</span>
                            </div>
                            <!-- Chevron Icon -->
                            <svg class="w-4 h-4 shrink-0 transition-transform duration-200 sidebar-text chevron-icon {{ request()->routeIs('admin.news.*') ? 'rotate-180 text-white' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Submenu Wrapper -->
                        <div class="sidebar-text transition-opacity duration-200">
                            <ul class="submenu-content space-y-1 mt-1 {{ request()->routeIs('admin.news.*') ? '' : 'hidden' }}">
                                <li>
                                    <a href="{{ route('admin.news.index') }}" class="flex items-center pl-11 pr-3 py-2 text-sm font-semibold rounded-xl transition-colors {{ request()->routeIs('admin.news.index') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:text-textclr-100 hover:bg-bgclr-300/20' }}">
                                        All news
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.news.create') }}" class="flex items-center pl-11 pr-3 py-2 text-sm font-semibold rounded-xl transition-colors {{ request()->routeIs('admin.news.create') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:text-textclr-100 hover:bg-bgclr-300/20' }}">
                                        Create news
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                <!-- Settings (Principal only) -->
                @role('Principal')
                    <li>
                        <a href="{{ route('admin.settings.index') }}" class="nav-link flex items-center px-3 py-2.5 rounded-xl group transition-all duration-200 relative {{ request()->routeIs('admin.settings.*') ? 'text-white bg-primary-300 font-semibold shadow-sm' : 'text-textclr-200 hover:bg-bgclr-300/20 hover:text-textclr-100' }}">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.settings.*') ? 'text-white' : 'text-textclr-200 group-hover:text-textclr-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="sidebar-text ml-3 font-semibold whitespace-nowrap transition-opacity duration-200">University Settings</span>
                            @if(request()->routeIs('admin.settings.*'))
                                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-primary-300 rounded-r-full"></div>
                            @endif
                        </a>
                    </li>
                @endrole
            </ul>
        </nav>

        <!-- User Profile (Bottom) -->
        <div class="p-4 border-t border-bgclr-300 shrink-0">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="nav-link flex items-center w-full p-2 rounded-xl hover:bg-bgclr-300/30 transition-colors group">
                        <div class="w-9 h-9 rounded-full bg-primary-100 text-primary-300 flex items-center justify-center font-bold text-xs uppercase shadow-sm shrink-0 border border-bgclr-300">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="sidebar-text ml-3 text-left overflow-hidden transition-opacity duration-200 flex-1">
                            <p class="text-sm font-semibold text-textclr-100 whitespace-nowrap">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-textclr-200 whitespace-nowrap">{{ auth()->user()->roles->pluck('name')->first() ?? 'User' }}</p>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col overflow-hidden bg-bgclr-100">
        <!-- Header / Topbar -->
        <header class="h-16 bg-[#e6dee4]/90 backdrop-blur-md border-b border-bgclr-300 flex items-center justify-between px-8 sticky top-0 z-10 shrink-0">
            <div class="flex items-center gap-4 flex-1">
                @isset($header)
                    <div class="text-lg font-semibold text-textclr-100">
                        {{ $header }}
                    </div>
                @else
                    <h1 class="text-lg font-semibold text-textclr-100">Dashboard</h1>
                @endisset
            </div>

            <!-- Red door/exit icon for logout -->
            <div class="flex items-center gap-4">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-accent-250 hover:text-accent-200 focus:outline-none p-2 rounded-lg hover:bg-accent-100/30 transition-colors" title="Log Out">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Body slot -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto p-8 max-w-7xl w-full mx-auto">
            {{ $slot }}
        </div>
    </main>

    <!-- JavaScript Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggle-btn');
            const header = document.getElementById('sidebar-header');
            
            // Text elements that disappear when collapsed
            const textElements = document.querySelectorAll('.sidebar-text');
            // Toggle buttons for submenus
            const submenuToggles = document.querySelectorAll('.submenu-toggle');

            // --- Sidebar Toggle Functions ---
            function expandSidebar() {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                
                header.classList.remove('justify-center');
                header.classList.add('justify-between', 'px-4');

                textElements.forEach(el => {
                    el.classList.remove('hidden');
                    setTimeout(() => el.classList.remove('opacity-0'), 10);
                });
            }

            function collapseSidebar() {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                
                header.classList.remove('justify-between', 'px-4');
                header.classList.add('justify-center');

                textElements.forEach(el => {
                    el.classList.add('opacity-0');
                    setTimeout(() => el.classList.add('hidden'), 200);
                });

                document.querySelectorAll('.submenu-content').forEach(sub => sub.classList.add('hidden'));
                document.querySelectorAll('.chevron-icon').forEach(icon => icon.classList.remove('rotate-180'));
            }

            // --- Event Listeners ---

            // Main Toggle Click
            toggleBtn.addEventListener('click', () => {
                if (sidebar.classList.contains('w-64')) {
                    collapseSidebar();
                } else {
                    expandSidebar();
                }
            });

            // Submenu Click Logic
            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', () => {
                    if (sidebar.classList.contains('w-20')) {
                        expandSidebar();
                        setTimeout(() => {
                            toggleSubmenuVisibility(toggle);
                        }, 50);
                    } else {
                        toggleSubmenuVisibility(toggle);
                    }
                });
            });

            function toggleSubmenuVisibility(toggleBtn) {
                const submenuContent = toggleBtn.nextElementSibling.querySelector('.submenu-content');
                const chevron = toggleBtn.querySelector('.chevron-icon');
                
                if (submenuContent.classList.contains('hidden')) {
                    submenuContent.classList.remove('hidden');
                    chevron.classList.add('rotate-180');
                } else {
                    submenuContent.classList.add('hidden');
                    chevron.classList.remove('rotate-180');
                }
            }
            // --- Global Print Filename Customization ---
            window.addEventListener('beforeprint', () => {
                window.originalDocumentTitle = document.title;
                document.title = "certificate";
            });
            window.addEventListener('afterprint', () => {
                if (window.originalDocumentTitle) {
                    document.title = window.originalDocumentTitle;
                }
            });
        });
    </script>
</body>
</html>
