@section('title', 'Tambah Jadwal Mapel')
<x-app-layout>
    <div class="py-10 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 backdrop-blur shadow-xl rounded-2xl p-8 border border-gray-100">
            <!-- Header -->
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-extrabold text-indigo-700">Tambah Jadwal Mapel</h2>
                <p class="mt-2 text-gray-500 text-sm">Lengkapi form di bawah untuk menambahkan jadwal mapel baru.</p>
            </div>

            <!-- Error Message -->
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700">
                <strong class="font-semibold">Periksa kembali input anda!</strong>
                <ul class="mt-2 text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('admin.schedule.store') }}" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <!-- Mata Pelajaran & Hari -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Mata Pelajaran - Guru -
                            Kelas</label>
                        <select name="subject_teacher_id" id="subject_teacher_id" required
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">-- Pilih --</option>
                            @foreach ($subjectTeachers as $st)
                            <option value="{{ $st->id }}" {{ old('subject_teacher_id') }}>
                                {{ $st->subject->name }} - {{ $st->teacher->name }} (Kelas {{ $st->grade->name }})
                            </option>
                            @endforeach
                        </select>
                        @error('subject_teacher_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Hari</label>
                        <select name="day" id="day" required
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="">-- Pilih Hari --</option>
                            <option value="Senin" {{ old('day') }}>Senin</option>
                            <option value="Selasa" {{ old('day') }}>Selasa</option>
                            <option value="Rabu" {{ old('day') }}>Rabu</option>
                            <option value="Kamis" {{ old('day') }}>Kamis</option>
                            <option value="Jumat" {{ old('day') }}>Jumat</option>
                            <option value="Sabtu" {{ old('day') }}>Sabtu</option>
                        </select>
                        @error('day') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Jam Masuk & Jam Selesai -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Masuk</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" required
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @error('start_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Selesai</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" required
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @error('end_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.schedule.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 transition shadow-sm">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold shadow hover:shadow-lg transform hover:scale-[1.02] transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>