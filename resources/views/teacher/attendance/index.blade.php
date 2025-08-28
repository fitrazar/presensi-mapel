@section('title', 'Presensi Mapel')
<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        @if(!$schedule)
        <div class="bg-red-100 text-red-600 p-4 rounded-lg shadow">
            Tidak ada jadwal aktif saat ini.
        </div>
        @else
        <div class="bg-white shadow-xl rounded-2xl p-6">
            <h1 class="text-2xl font-bold text-blue-600 mb-4">
                📘 Presensi Mapel {{ $schedule->subjectTeacher->subject->name }} ({{
                $schedule->subjectTeacher->grade->full_class_name }})
            </h1>
            <p class="text-gray-600 mb-6">
                {{ $schedule->day }} ({{ $schedule->start_time }} - {{ $schedule->end_time }}) <br>
                Guru: {{ $schedule->subjectTeacher->teacher->name }}
            </p>

            <table id="attendanceTable" class="w-full border border-gray-200 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">NISN</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Status</th>
                    </tr>
                </thead>
            </table>
        </div>
        @endif
    </div>

    <x-slot name="script">

        <script>
            $(function () {
        let table = $('#attendanceTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('teacher.attendance.index', $schedule->id) }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'nisn', name: 'nisn'},
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
            ]
        });

        // Update realtime
        $(document).on('change', '.status-select', function() {
            let student_id = $(this).data('id');
            let schedule_id = $(this).data('schedule');
            let status = $(this).val();
            if (!status) return;

            $.ajax({
                url: "{{ route('teacher.attendance.updateStatus') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    student_id: student_id,
                    schedule_id: schedule_id,
                    status: status,
                },
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Status presensi diperbarui.',
                        timer: 800,
                        showConfirmButton: false
                    });
                }
            });
        });
    });
        </script>
    </x-slot>
</x-app-layout>