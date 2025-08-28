@section('title', 'Laporan Presensi')
<x-app-layout>
    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Filter -->
        <div class="bg-white shadow-md rounded-2xl p-6 mb-6 flex flex-col md:flex-row md:items-end gap-4">
            <form method="GET" action="{{ route('teacher.report.index') }}" class="flex flex-wrap gap-4">
                <div>
                    <label class="block text-sm font-medium">Tanggal Awal</label>
                    <input type="date" name="start_date" value="{{ $start_date }}"
                        class="border rounded-lg px-3 py-2 w-48">
                </div>
                <div>
                    <label class="block text-sm font-medium">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ $end_date }}" class="border rounded-lg px-3 py-2 w-48">
                </div>

                <div class="flex items-end">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
                        Filter
                    </button>
                </div>
            </form>
            <div class="flex gap-3 ml-auto">
                <form method="GET" action="{{ route('teacher.report.exportExcel') }}">
                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow">
                        Export Excel
                    </button>
                </form>
                <form method="GET" action="{{ route('teacher.report.exportPdf') }}">
                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                    <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow">
                        Export PDF
                    </button>
                </form>
            </div>
        </div>

        <!-- Statistik Presensi -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-6">
            @php
            $statusList = ['Hadir','Izin','Sakit','Pulang Sakit','Alpa','Pulang','Keluar'];
            $colors = ['green','yellow','blue','purple','red','gray','pink'];
            @endphp
            @foreach($statusList as $i => $status)
            <div class="bg-{{ $colors[$i] }}-100 p-4 rounded-xl shadow text-center">
                <div class="text-xl font-bold">{{ $statusCounts[$status] ?? 0 }}</div>
                <div class="text-sm">{{ $status }}</div>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl shadow p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4">Distribusi Presensi</h2>
                <canvas id="attendanceChart" height="120"></canvas>
            </div>

            <!-- Mapel Hari Ini -->
            <div class="bg-white rounded-2xl shadow p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4">Total Presensi per Mapel (Hari ini)</h2>
                <div class="grid md:grid-cols-3 gap-4">
                    @foreach($mapelHariIni as $mapel)
                    <div class="bg-blue-100 p-4 rounded-lg text-center shadow">
                        <div class="text-xl font-bold">{{ $mapel->total }}</div>
                        <div class="text-sm">
                            {{ $mapel->schedule->subjectTeacher->subject->name ?? 'Mapel' }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white shadow rounded-xl p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Ringkasan Presensi Per Kelas</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full border rounded-lg">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border">Kelas</th>
                                <th class="px-4 py-2 border">Hadir</th>
                                <th class="px-4 py-2 border">Izin</th>
                                <th class="px-4 py-2 border">Sakit</th>
                                <th class="px-4 py-2 border">Pulang Sakit</th>
                                <th class="px-4 py-2 border">Alpa</th>
                                <th class="px-4 py-2 border">Pulang</th>
                                <th class="px-4 py-2 border">Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perClass as $kelas => $data)
                            <tr>
                                <td class="px-4 py-2 border font-medium">{{ $kelas }}</td>
                                <td class="px-4 py-2 border text-center">{{ $data['Hadir'] ?? 0 }}</td>
                                <td class="px-4 py-2 border text-center">{{ $data['Izin'] ?? 0 }}</td>
                                <td class="px-4 py-2 border text-center">{{ $data['Sakit'] ?? 0 }}</td>
                                <td class="px-4 py-2 border text-center">{{ $data['Pulang Sakit'] ?? 0 }}</td>
                                <td class="px-4 py-2 border text-center">{{ $data['Alpa'] ?? 0 }}</td>
                                <td class="px-4 py-2 border text-center">{{ $data['Pulang'] ?? 0 }}</td>
                                <td class="px-4 py-2 border text-center">{{ $data['Keluar'] ?? 0 }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top 5 Siswa Hadir -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Top 5 Siswa Hadir Terbanyak</h2>
                <ol class="list-decimal pl-5 space-y-1">
                    @foreach($topHadir as $item)
                    <li>
                        {{ $item->student->name ?? 'Siswa' }} - {{ $item->total }}x Hadir
                    </li>
                    @endforeach
                </ol>
            </div>
        </div>

    </div>
    <x-slot name="script">
        <script>
            const ctx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json(array_keys($statusCounts->toArray())),
            datasets: [{
                data: @json(array_values($statusCounts->toArray())),
                backgroundColor: [
                    '#4ade80','#facc15','#60a5fa','#a78bfa','#f87171','#9ca3af','#f472b6'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
        </script>
    </x-slot>
</x-app-layout>