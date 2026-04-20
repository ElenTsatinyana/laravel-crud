<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Header -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Welcome back</h2>
            <p class="text-sm text-gray-500 mt-1">Sign in to your account</p>
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700 mb-1" />
            <x-text-input 
                id="email" 
                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required autofocus autocomplete="username" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div  class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700 mb-1" />
            <x-text-input 
                id="password" 
                class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                type="password"
                name="password"
                required autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="mt-4 flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" 
                    name="remember"
                >
                <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                   class="text-sm text-blue-600 hover:text-blue-800 transition-colors">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <x-primary-button class="mt-4 w-full justify-center py-2.5 rounded-xl text-sm font-semibold tracking-wide uppercase bg-gray-900 hover:bg-gray-700 transition-colors">
            {{ __('Log in') }}
        </x-primary-button>

        <!-- Register Link -->
        <p class="mt-4 text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline ml-1">
                Register here
            </a>
        </p>

    </form>
</x-guest-layout>