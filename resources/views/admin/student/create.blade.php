@section('title', 'Tambah Siswa')
<x-app-layout>
    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-2xl p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-700">Tambah Siswa Baru</h2>

            <form method="POST" action="{{ route('admin.student.store') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <!-- Username & Password -->

                <!-- Name & NISN -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">NISN</label>
                        <input type="number" name="nisn" value="{{ old('nisn') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('nisn') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Phone & Gender -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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


                <!-- Submit -->
                <div class="flex justify-end">
                    <a href="{{ route('admin.student.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg mr-2">Batal</a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>