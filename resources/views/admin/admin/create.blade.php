@section('title', 'Tambah User')
<x-app-layout>
    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-2xl p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-700">Tambah Admin Baru</h2>

            <form method="POST" action="{{ route('admin.admin.store') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <!-- Username & Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Username -->
                    <div x-data="{ value: '{{ old('username') }}' }">
                        <label class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="username" x-model="value" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                        <!-- Live Validation -->
                        <div class="mt-1 space-y-1 text-sm">
                            <p :class="value.length >= 3 ? 'text-green-600' : 'text-red-500'">
                                Minimal 3 karakter
                            </p>
                            <p :class="value.length <= 10 && value.length > 0 ? 'text-green-600' : 'text-red-500'">
                                Maksimal 10 karakter
                            </p>
                        </div>

                        @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div x-data="{ show: false, value: '' }">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative mt-1">
                            <input :type="show ? 'text' : 'password'" name="password" x-model="value" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pr-12 pl-3 py-2">

                            <!-- Toggle Eye -->
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-2 flex items-center px-2 rounded-full hover:bg-gray-100 transition">
                                <i x-show="!show" class="fa-solid fa-eye-slash text-gray-500"></i>
                                <i x-show="show" class="fa-solid fa-eye text-gray-500"></i>
                            </button>
                        </div>

                        <!-- Live Validation -->
                        <div class="mt-1 space-y-1 text-sm">
                            <p :class="value.length >= 6 ? 'text-green-600' : 'text-red-500'">
                                Minimal 6 karakter
                            </p>
                            <p :class="value.length <= 20 && value.length > 0 ? 'text-green-600' : 'text-red-500'">
                                Maksimal 20 karakter
                            </p>
                        </div>

                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Name & Phone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. HP</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="gender" required
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Pilih Gender --</option>
                        <option value="Laki - Laki" {{ old('gender')=='Laki - Laki' ? 'selected' : '' }}>Laki - Laki
                        </option>
                        <option value="Perempuan" {{ old('gender')=='Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Photo -->
                <div x-data="{
                        progress: 0,
                        previewUrl: '',
                        uploadFile(event) {
                            const file = event.target.files[0];
                            if (!file) return;

                            // Preview gambar
                            this.previewUrl = URL.createObjectURL(file);

                            // Simulasi progress bar (jika tidak pakai upload AJAX)
                            this.progress = 0;
                            const interval = setInterval(() => {
                                this.progress += 10;
                                if (this.progress >= 100) {
                                    clearInterval(interval);
                                }
                            }, 100);
                        }
                    }" class="space-y-4">
                    <label class="block text-sm font-medium text-gray-700">Foto</label>

                    <!-- Custom Upload Box -->
                    <div class="relative flex flex-col items-center justify-center w-full p-6 border-2 border-dashed rounded-2xl cursor-pointer transition hover:border-indigo-400 hover:bg-indigo-50"
                        @click="$refs.fileInput.click()">
                        <input type="file" name="photo" id="photo" accept="image/*" class="hidden" x-ref="fileInput"
                            x-on:change="uploadFile($event)">

                        <!-- Icon Upload -->
                        <div class="flex flex-col items-center text-gray-500">
                            <i class="fa-solid fa-cloud-arrow-up text-4xl mb-2"></i>
                            <span class="text-sm">Klik untuk upload</span>
                            <span class="text-xs text-gray-400">PNG, JPG, JPEG (max 2MB)</span>
                        </div>
                    </div>

                    @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Preview Gambar -->
                    <div class="mt-3 flex justify-center" x-show="previewUrl">
                        <img :src="previewUrl"
                            class="w-32 h-32 object-cover rounded-full shadow-lg ring-2 ring-indigo-400" />
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2 overflow-hidden" x-show="progress > 0">
                        <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-300"
                            :style="`width: ${progress}%;`"></div>
                    </div>
                    <p class="text-xs text-gray-500" x-show="progress < 100 && progress > 0">
                        Mengunggah... <span x-text="progress + '%'"></span>
                    </p>
                    <p class="text-xs text-green-600 font-medium" x-show="progress >= 100">✅ Upload selesai!</p>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <a href="{{ route('admin.admin.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg mr-2">Batal</a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="script">

        <script>
            function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        </script>
    </x-slot>
</x-app-layout>