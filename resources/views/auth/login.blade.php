<x-guest-layout>
    <!-- Welcome Header -->
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Welcome Back</h2>
        <p class="text-sm text-gray-500 mt-1">Please sign in to access your certificate dashboard</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">
                {{ __('Email Address') }}
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#0a3a60] focus:ring-2 focus:ring-[#0a3a60]/20 transition-all duration-200 outline-none text-sm text-gray-700 placeholder-gray-400 shadow-sm"
                       placeholder="you@university.edu" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-500">
                    {{ __('Password') }}
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-[#0a3a60] hover:text-[#f7941d] transition-colors duration-200" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#0a3a60] focus:ring-2 focus:ring-[#0a3a60]/20 transition-all duration-200 outline-none text-sm text-gray-700 placeholder-gray-400 shadow-sm"
                       placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 text-[#0a3a60] border-gray-300 rounded focus:ring-[#0a3a60] transition-colors duration-150 cursor-pointer" />
            <label for="remember_me" class="ml-2 text-sm text-gray-600 cursor-pointer select-none">
                {{ __('Keep me signed in') }}
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                    class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-semibold text-white bg-gradient-to-r from-[#0a3a60] to-[#0d4a7a] hover:from-[#0d4a7a] hover:to-[#0a3a60] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0a3a60] transition-all duration-200 transform active:scale-[0.98]">
                {{ __('Sign In') }}
            </button>
        </div>
    </form>

    <!-- Footer Links -->
    <div class="mt-6 pt-5 border-t border-gray-100 text-center text-sm text-gray-500">
        {{ __("Don't have an account?") }}
        <a href="{{ route('register') }}" class="font-semibold text-[#0a3a60] hover:text-[#f7941d] transition-colors duration-200">
            {{ __('Sign up now') }}
        </a>
    </div>
</x-guest-layout>
