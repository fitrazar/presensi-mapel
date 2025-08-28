@section('title', 'Dashboard')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-gray-500 text-sm">Total Siswa</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $totalStudents }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-gray-500 text-sm">Total Guru</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $totalTeachers }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-gray-500 text-sm">Total Mapel</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalSubjects }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-gray-500 text-sm">Presensi Hari Ini</h3>
                    <p class="text-3xl font-bold text-red-600">
                        {{ $todayAttendance }} / {{ $totalTodayStudents }}
                    </p>
                </div>
            </div>

            <!-- Chart + Recent Presensi -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Chart -->
                <div class="bg-white p-6 rounded-2xl shadow">
                    <h2 class="text-lg font-semibold mb-4">Persentase Kehadiran</h2>
                    <canvas id="attendanceChart"></canvas>
                </div>

                <!-- Recent Presensi -->
                <div class="bg-white p-6 rounded-2xl shadow">
                    <h2 class="text-lg font-semibold mb-4">Presensi Terbaru</h2>
                    <ul class="divide-y divide-gray-100">
                        @forelse($recentAttendances as $attendance)
                        <li class="py-3 flex justify-between">
                            <span>
                                {{ $attendance->student->name }} ({{
                                $attendance->schedule->subjectTeacher->subject->name ?? 'Tanpa Mapel' }}
                                - {{ $attendance->schedule->subjectTeacher->grade->full_class_name ?? '-' }})

                            </span>
                            <span class="font-semibold
                                    {{ $attendance->status === 'Hadir' ? 'text-green-600' : 
                                       ($attendance->status === 'Alpa' ? 'text-yellow-600' : 
                                       'text-red-600') }}">
                                @switch($attendance->status)
                                @case('Hadir')
                                Hadir
                                @break
                                @case('Sakit')
                                Sakit
                                @break
                                @case('Izin')
                                Izin
                                @break
                                @default
                                Alpha
                                @endswitch
                            </span>
                        </li>
                        @empty
                        <li class="py-3 text-gray-500 text-sm">Belum ada presensi terbaru</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <x-slot name="script">
        <script>
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Hadir', 'Tidak Hadir'],
                    datasets: [{
                        data: [{{ $todayAttendance }}, {{ $totalTodayStudents - $todayAttendance }}],
                        backgroundColor: ['#4F46E5', '#EF4444']
                    }]
                }
            });
        </script>
    </x-slot>
</x-app-layout>