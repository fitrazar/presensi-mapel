@section('title', 'Dashboard')
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-gray-500 text-sm">Total Siswa</h3>
                    <p class="text-3xl font-bold text-indigo-600">320</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-gray-500 text-sm">Total Guru</h3>
                    <p class="text-3xl font-bold text-green-600">25</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-gray-500 text-sm">Total Mapel</h3>
                    <p class="text-3xl font-bold text-blue-600">12</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                    <h3 class="text-gray-500 text-sm">Presensi Hari Ini</h3>
                    <p class="text-3xl font-bold text-red-600">280 / 320</p>
                </div>
            </div>

            <!-- Chart + Recent Presensi -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Dummy Chart -->
                <div class="bg-white p-6 rounded-2xl shadow">
                    <h2 class="text-lg font-semibold mb-4">Persentase Kehadiran</h2>
                    <canvas id="attendanceChart"></canvas>
                </div>

                <!-- Recent Presensi -->
                <div class="bg-white p-6 rounded-2xl shadow">
                    <h2 class="text-lg font-semibold mb-4">Presensi Terbaru</h2>
                    <ul class="divide-y divide-gray-100">
                        <li class="py-3 flex justify-between">
                            <span>Matematika - Kelas 10</span>
                            <span class="text-green-600 font-semibold">95% Hadir</span>
                        </li>
                        <li class="py-3 flex justify-between">
                            <span>Bahasa Inggris - Kelas 11</span>
                            <span class="text-yellow-600 font-semibold">80% Hadir</span>
                        </li>
                        <li class="py-3 flex justify-between">
                            <span>Fisika - Kelas 12</span>
                            <span class="text-red-600 font-semibold">65% Hadir</span>
                        </li>
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
                    data: [280, 40],
                    backgroundColor: ['#4F46E5', '#EF4444']
                }]
            }
        });
        </script>
    </x-slot>
</x-app-layout>