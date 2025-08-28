@section('title', 'Dashboard Guru')
<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-2xl shadow-md">
                    <h3 class="text-sm">Total Mapel Diampu</h3>
                    <p class="text-3xl font-bold">{{ $subjectTeachers->count() }}</p>
                </div>
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-6 rounded-2xl shadow-md">
                    <h3 class="text-sm">Jadwal Minggu Ini</h3>
                    <p class="text-3xl font-bold">{{ $latestSchedules->count() }}</p>
                </div>
                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 text-white p-6 rounded-2xl shadow-md">
                    <h3 class="text-sm">Presensi Hari Ini</h3>
                    <p class="text-3xl font-bold">
                        {{ $attendanceStats->sum() }} Siswa
                    </p>
                </div>
                <div class="bg-gradient-to-r from-pink-500 to-rose-600 text-white p-6 rounded-2xl shadow-md">
                    <h3 class="text-sm">Status Kehadiran</h3>
                    <ul class="text-xs space-y-1 mt-2">
                        @foreach($attendanceStats as $status => $total)
                        <li>{{ $status }}: {{ $total }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Jadwal Mengajar Terbaru -->
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <h2 class="text-lg font-semibold mb-4">📅 Jadwal Terbaru</h2>
                <ul class="divide-y divide-gray-100">
                    @forelse($latestSchedules as $schedule)
                    <li class="py-3 flex justify-between">
                        <span>
                            {{ $schedule->subjectTeacher->subject->name }} -
                            {{ $schedule->subjectTeacher->grade->full_class_name }}
                        </span>
                        <span class="text-gray-600 text-sm">
                            {{ $schedule->day }} ({{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }})

                        </span>
                    </li>
                    @empty
                    <li class="py-3 text-gray-500 text-sm">Tidak ada jadwal terbaru</li>
                    @endforelse
                </ul>
            </div>

            <!-- Jika wali kelas -->
            @if($teacher->is_roommates)
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <h2 class="text-lg font-semibold mb-4">👨‍🎓 Siswa Kelas {{ $teacher->grade->full_class_name }}</h2>
                <table class="w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">No</th>
                            <th class="p-2 border">Nama</th>
                            <th class="p-2 border">NIS</th>
                            <th class="p-2 border">JK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classStudents as $i => $student)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border text-center">{{ $i+1 }}</td>
                            <td class="p-2 border">{{ $student->name }}</td>
                            <td class="p-2 border">{{ $student->nisn }}</td>
                            <td class="p-2 border">{{ $student->gender }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif


            @if($teacher->is_roommates)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top 5 -->
                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <h2 class="text-lg font-semibold mb-4">🏆 5 Siswa Kehadiran Terbaik</h2>
                    <ul class="divide-y divide-gray-100">
                        @forelse($topStudents as $s)
                        <li class="py-2 flex justify-between">
                            <span>{{ $s->student->name ?? 'Unknown' }}</span>
                            <span class="text-green-600 font-semibold">{{ $s->hadir_count }} Hadir</span>
                        </li>
                        @empty
                        <li class="py-2 text-gray-500 text-sm">Belum ada data</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Bottom 5 -->
                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <h2 class="text-lg font-semibold mb-4">⚠️ 5 Siswa Kehadiran Terburuk</h2>
                    <ul class="divide-y divide-gray-100">
                        @forelse($bottomStudents as $s)
                        <li class="py-2 flex justify-between">
                            <span>{{ $s->student->name ?? 'Unknown' }}</span>
                            <span class="text-red-600 font-semibold">{{ $s->alpa_count }} Alpa</span>
                        </li>
                        @empty
                        <li class="py-2 text-gray-500 text-sm">Belum ada data</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            @endif

            <!-- Statistik Kehadiran Chart -->
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <h2 class="text-lg font-semibold mb-4">📊 Statistik Kehadiran Hari Ini</h2>
                <canvas id="attendanceChart"></canvas>
            </div>

        </div>
    </div>

    <x-slot name="script">
        <script>
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($attendanceStats->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($attendanceStats->values()) !!},
                        backgroundColor: ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#EC4899', '#6366F1']
                    }]
                }
            });
        </script>
    </x-slot>
</x-app-layout>