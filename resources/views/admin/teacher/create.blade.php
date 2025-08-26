@section('title', 'Tambah Guru')
<x-app-layout>
    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-2xl p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-700">Tambah Guru Baru</h2>

            <form method="POST" action="{{ route('admin.teacher.store') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <!-- Username & Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Username</label>
                        <div class="flex items-center space-x-2">
                            <input type="text" id="username" name="username" value="{{ old('username') }}" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <input type="number" id="digitCount" value="4" min="4" max="10"
                                class="w-16 mt-1 rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-center"
                                title="Jumlah digit">
                            <button type="button" onclick="generateRandom()"
                                class="btn btn-primary rounded btn-sm mt-1">
                                Acak
                            </button>
                        </div>
                        @error('username') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative mt-1">
                            <input :type="show ? 'text' : 'password'" id="password" name="password" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pr-12 pl-3 py-2">

                            <!-- Tombol mata -->
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-2 flex items-center px-2 rounded-full hover:bg-gray-100 transition">

                                <!-- Eye closed -->
                                <i x-show="!show" class="fa-solid fa-eye-slash text-gray-500"></i>

                                <!-- Eye open -->
                                <i x-show="show" class="fa-solid fa-eye text-gray-500"></i>
                            </button>
                        </div>
                        @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <!-- Name & NIP -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('nip') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Phone & Gender -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. HP</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="gender" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Pilih Gender --</option>
                            <option value="Laki - Laki" {{ old('gender')=='Laki - Laki' ? 'selected' : '' }}>Laki - Laki
                            </option>
                            <option value="Perempuan" {{ old('gender')=='Perempuan' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                        @error('gender') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Grade -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kelas</label>
                    <select name="grade_id"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($grades as $grade)
                        <option value="{{ $grade->id }}" {{ old('grade_id')==$grade->id ? 'selected' : '' }}>
                            {{ $grade->full_class_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('grade_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Wali Kelas -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_roommates" value="1" {{ old('is_roommates') ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    <label class="ml-2 block text-sm text-gray-700">Wali Kelas</label>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <a href="{{ route('admin.teacher.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg mr-2">Batal</a>
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
            function generateRandom() {
                let count = document.getElementById('digitCount').value || 4;
                let result = '';
                for (let i = 0; i < count; i++) {
                    result += Math.floor(Math.random() * 10); // angka 0-9
                }
                document.getElementById('username').value = result;
                document.getElementById('password').value = result;
            }
        </script>
    </x-slot>
</x-app-layout>