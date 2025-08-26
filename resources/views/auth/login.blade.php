@section('title', 'Masuk')

<x-guest-layout>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-white to-blue-100 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 sm:p-10">

            <!-- Logo -->
            {{-- <div class="flex justify-center mb-6">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="w-24 h-24 rounded-full shadow-md">
            </div> --}}

            <!-- Welcome -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Selamat Datang</h1>
                <p class="text-sm text-gray-500">Silakan masuk untuk melanjutkan</p>
            </div>

            @if ($errors->any())
            <x-alert.error :errors="$errors->all()" />
            @endif

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <x-form action="{{ route('login') }}" class="w-full space-y-4">
                @csrf

                <!-- Username -->
                <div>
                    <x-input.input-label for="username" :value="__('Username')" />
                    <x-input.text-input id="username" class="mt-1 w-full" type="text" name="username"
                        :value="old('username')" required autofocus autocomplete="username" />
                    <x-input.input-error :messages="$errors->get('username')" class="mt-1" />
                </div>

                <!-- Password -->
                <div x-data="{ show: false }">
                    <x-input.input-label for="password" :value="__('Password')" />
                    <div class="relative mt-1">
                        <input :type="show ? 'text' : 'password'" id="password" name="password"
                            class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200" required
                            autocomplete="current-password" />
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 focus:outline-none">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.993 9.993 0 013.065-4.412M6.4 6.4A9.965 9.965 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.974 9.974 0 01-4.205 5.234M15 12a3 3 0 01-4.65 2.55M9.878 9.878A3 3 0 0115 12m-6 0a3 3 0 003 3m9 6l-18-18" />
                            </svg>
                        </button>
                    </div>
                    <x-input.input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Remember -->
                <div class="flex items-center">
                    <x-input.checkbox name="remember" id="remember" class="mr-2" />
                    <label for="remember" class="text-sm text-gray-600">Ingat Saya</label>
                </div>

                <!-- Button -->
                <x-button.primary-button class="w-full mt-2">
                    {{ __('Masuk') }}
                </x-button.primary-button>
            </x-form>
        </div>
    </div>
</x-guest-layout>