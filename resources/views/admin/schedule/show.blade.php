@section('title', 'Detail Jadwal')

<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Detail Jadwal Pelajaran</h1>
            <p class="text-gray-500">Informasi lengkap tentang jadwal yang dipilih</p>
        </div>

        <!-- Card -->
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-6 text-white">
                <h2 class="text-2xl font-bold">📚 {{ $schedule->subjectTeacher->subject->name }}</h2>
                <p class="text-lg">👨‍🏫 {{ $schedule->subjectTeacher->teacher->name }}</p>
            </div>

            <div class="p-6 space-y-6">
                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center gap-4">
                        <div class="bg-indigo-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7H3v12a2 2 0 0 0 2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Hari</p>
                            <p class="text-lg font-semibold">{{ ucfirst($schedule->day) }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jam</p>
                            <p class="text-lg font-semibold">{{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="bg-pink-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path d="M12 14v7m0-7l9-5m-9 5l-9-5" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kelas</p>
                            <p class="text-lg font-semibold">{{ $schedule->subjectTeacher->grade->full_class_name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="bg-yellow-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kode Mapel</p>
                            <p class="text-lg font-semibold">{{ $schedule->subjectTeacher->subject->code ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end mt-6 space-x-3">
            <a href="{{ route('admin.schedule.index') }}"
                class="px-5 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium transition">
                ⬅️ Kembali
            </a>
            <a href="{{ route('admin.schedule.edit', $schedule->id) }}"
                class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-medium transition">
                ✏️ Edit Jadwal
            </a>
        </div>
    </div>
</x-app-layout>