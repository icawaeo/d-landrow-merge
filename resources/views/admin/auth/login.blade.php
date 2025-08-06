<x-guest-layout>
    <div class="flex justify-center mb-6">
        <img src="{{ asset('images/logo-pln.png') }}" alt="Logo PLN" class="w-20 h-auto">
    </div>

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
        Login Admin D-Landrow
    </h2>
    <p class="text-center text-gray-600 mb-12">
        Silakan masuk menggunakan akun admin Anda.
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input 
                id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required autofocus 
                autocomplete="username" 
                placeholder="contoh@pln.co.id"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input 
                id="password" 
                class="block mt-1 w-full" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                {{ __('Login sebagai User') }}
            </a>
            <x-primary-button class="ms-3">
                {{ __('Masuk sebagai Admin') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
