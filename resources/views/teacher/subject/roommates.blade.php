@section('title', 'Mapel Kelas')
<x-app-layout>
    <div class="py-10 max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-sky-400 via-indigo-400 to-purple-400 rounded-2xl p-1 shadow-xl">
            <div class="bg-white rounded-2xl p-8">

                <!-- Header -->
                <div class="mb-10 text-center">
                    <h2 class="text-3xl font-extrabold text-indigo-600">
                        📚 Daftar Mapel Kelas {{ $teacher->grade->full_class_name }}
                    </h2>
                    <p class="mt-2 text-gray-600">
                        Anda adalah wali kelas di kelas ini. Silakan pilih mapel untuk melihat presensi.
                    </p>
                </div>

                <!-- List Mapel -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($subjects as $subject)
                    <div
                        class="group bg-gradient-to-br from-pink-300 via-purple-300 to-indigo-300 p-1 rounded-2xl shadow-md hover:scale-[1.02] transform transition duration-300">
                        <div class="bg-white rounded-2xl p-6 h-full flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-indigo-700 group-hover:text-pink-600 transition">
                                    {{ $subject->subject->name }}
                                </h3>
                                <p class="mt-2 text-sm text-gray-500">
                                    Guru: {{ $subject->teacher->name ?? 'Belum ada' }}
                                </p>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('teacher.roommates.attendance', [$teacher->grade->id, $subject->id]) }}"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 rounded-xl
                                        bg-gradient-to-r from-indigo-400 to-sky-400
                                        text-white font-semibold shadow hover:from-indigo-500 hover:to-sky-500
                                        transition duration-300">
                                    👀 Lihat Presensi
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>