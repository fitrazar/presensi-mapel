@section('title', 'Presensi Siswa')
<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Jika wali kelas -->
            @if($teacher->is_roommates)
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <h2 class="text-lg font-semibold mb-4">👨‍🎓 Presensi Siswa Kelas {{ $teacher->grade->full_class_name }}
                    - Mapel {{ $subject->subject->name }} ({{ \Carbon\Carbon::today()->format('d-m-Y') }})</h2>
                <table class="w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">No</th>
                            <th class="p-2 border">Nama</th>
                            <th class="p-2 border">NIS</th>
                            <th class="p-2 border">JK</th>
                            <th class="p-2 border">Status</th>
                            <th class="p-2 border">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $i => $attendance)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border text-center">{{ $loop->iteration }}</td>
                            <td class="p-2 border">{{ $attendance->student->name }}</td>
                            <td class="p-2 border">{{ $attendance->student->nisn }}</td>
                            <td class="p-2 border">{{ $attendance->student->gender }}</td>
                            <td class="p-2 border">{{ $attendance->status }}</td>
                            <td class="p-2 border">{{ $attendance->date }}</td>
                        </tr>
                        @empty
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border text-center">
                                Data tidak ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @endif


        </div>
    </div>
</x-app-layout>