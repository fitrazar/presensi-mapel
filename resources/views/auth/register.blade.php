@section('title', 'Daftar Akun')

<x-guest-layout>
    <div class="py-12">
        <div class="w-2/3 mx-auto sm:px-6 lg:px-8">

            <x-card.card-default class="static">
                <h1 class="text-3xl font-bold text-gray-900 mb-2"><br>Selamat Datang</h1>
                <p class="text-sm text-gray-600 mb-6">Silahkan isi data diri Anda</p>

                @if ($errors->any())
                <div role="alert" class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                    @endforeach
                </div>
                @endif

                <x-form action="{{ route('register') }}" class="md:grid md:grid-cols-2 gap-4">
                    @csrf

                    <!-- First Name -->
                    <div>
                        <x-input.input-label for="first_name" :value="__('Nama Depan')" />
                        <x-input.text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                            :value="old('first_name')" required autofocus autocomplete="first_name"
                            placeholder="John" />
                        <x-input.input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <x-input.input-label for="last_name" :value="__('Nama Belakang')" />
                        <x-input.text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                            :value="old('last_name')" required autofocus autocomplete="last_name" placeholder="Doe" />
                        <x-input.input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>

                    <!-- Phone Number -->
                    <div class="mt-4">
                        <x-input.input-label for="phone" :value="__('No Telpon')" />
                        <x-input.text-input id="phone" class="block mt-1 w-full" type="phone" name="phone"
                            :value="old('phone')" required autocomplete="phone" placeholder="08xxxxx" />
                        <x-input.input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="mt-4">
                        <x-input.input-label for="birthplace" :value="__('Tempat Lahir')" />
                        <x-input.text-input id="birthplace" class="block mt-1 w-full" type="text" name="birthplace"
                            :value="old('birthplace')" required autocomplete="birthplace" placeholder="Purwakarta" />
                        <x-input.input-error :messages="$errors->get('birthplace')" class="mt-2" />
                    </div>

                    <!-- Tangga Lahir -->
                    <div class="mt-4">
                        <x-input.input-label for="birthdate" :value="__('Tanggal Lahir')" />
                        <x-input.text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate"
                            :value="old('birthdate')" required autocomplete="birthdate" placeholder="08xxxxx" />
                        <x-input.input-error :messages="$errors->get('birthdate')" class="mt-2" />
                    </div>

                    <!-- Gender -->
                    <div class="mt-4">
                        <x-input.input-label for="gender" :value="__('Jenis Kelamin')" />
                        <x-input.select-input id="gender" class="mt-1 w-full" type="text" name="gender" required
                            autofocus autocomplete="gender">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki - Laki" {{ old('gender')=='Laki - Laki' ? ' selected' : ' ' }}>Laki -
                                Laki
                            </option>
                            <option value="Perempuan" {{ old('gender')=='Perempuan' ? ' selected' : ' ' }}>Perempuan
                            </option>
                        </x-input.select-input>
                    </div>

                    <!-- Username -->
                    <div class="mt-4">
                        <x-input.input-label for="username" :value="__('Username')" />
                        <x-input.text-input id="username" class="block mt-1 w-full" type="text" name="username"
                            :value="old('username')" required autocomplete="username" placeholder="johndoe" />
                        <x-input.input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4" x-data="{
                                            show: false,
                                            password: '',
                                            get hasMinLength() { return this.password.length >= 8 }
                                        }">
                        <x-input.input-label for="password" :value="__('Password')" />

                        <label class="input text-base-content w-full mt-1">
                            <input :type="show ? 'text' : 'password'" id="password" name="password" class="mt-1 grow"
                                required autocomplete="new-password" x-model="password" />
                            <button type="button" @click="show = !show" class="ml-2 text-sm">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.993 9.993 0 013.065-4.412M6.4 6.4A9.965 9.965 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.974 9.974 0 01-4.205 5.234M15 12a3 3 0 01-4.65 2.55M9.878 9.878A3 3 0 0115 12m-6 0a3 3 0 003 3m9 6l-18-18" />
                                </svg>
                            </button>
                        </label>

                        {{-- Error message server-side --}}
                        <x-input.input-error :messages="$errors->get('password')" class="mt-2" />

                        {{-- Realtime Password Checklist --}}
                        <ul class="text-sm mt-2 space-y-1">
                            <li :class="hasMinLength ? 'text-success' : 'text-error'">
                                <i :class="hasMinLength ? 'fas fa-check-circle' : 'fas fa-circle-xmark'"
                                    class="mr-2"></i>
                                Minimal 8 karakter
                            </li>
                        </ul>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input.input-label for="password_confirmation" :value="__('Konfirmasi Password')" />

                        <x-input.text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />

                        <x-input.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4 col-span-2">
                        @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="link">
                            <x-button.link-button type="button">
                                {{ __('Sudah Daftar?') }}
                            </x-button.link-button>
                        </a>
                        @endif

                        <x-button.primary-button class="ms-4">
                            {{ __('Daftar') }}
                        </x-button.primary-button>
                    </div>
                </x-form>
            </x-card.card-default>
        </div>
    </div>
    <x-slot name="script">
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                        const birthdateInput = document.getElementById("birthdate");

                        const today = new Date();
                        const minAge = 13;
                        const maxAge = 60;

                        // Hitung batas maksimum dan minimum tanggal lahir
                        const maxDate = new Date(today.getFullYear() - minAge, today.getMonth(), today.getDate());
                        const minDate = new Date(today.getFullYear() - maxAge, today.getMonth(), today.getDate());

                        // Format ke yyyy-mm-dd
                        function formatDate(date) {
                            const month = (date.getMonth() + 1).toString().padStart(2, '0');
                            const day = date.getDate().toString().padStart(2, '0');
                            return `${date.getFullYear()}-${month}-${day}`;
                        }

                        birthdateInput.setAttribute("max", formatDate(maxDate));
                        birthdateInput.setAttribute("min", formatDate(minDate));
                    });
        </script>

    </x-slot>
</x-guest-layout>