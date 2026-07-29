<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 text-center">
        <div class="text-3xl mb-4">⏳</div>
        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ __('Registration Pending') }}</h2>
        <p>{{ __('Your account is pending approval by the Principal. Please wait or contact administration.') }}</p>
    </div>

    <div class="mt-6 flex items-center justify-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
