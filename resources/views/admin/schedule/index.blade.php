@section('title', 'Data Jadwal')
<x-app-layout>
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Flash Message -->
        @if (session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white shadow-md rounded-2xl p-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center mb-6 gap-3">
                <h2 class="text-2xl font-bold text-gray-700">Data Jadwal</h2>
                <a href="{{ route('admin.schedule.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
                    + Tambah Jadwal
                </a>

                <form action="{{ route('admin.schedule.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="input">
                    <button
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 transition"
                        type="submit">
                        Import Jadwal
                    </button>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table id="scheduleTable" class="min-w-full border-collapse">
                    <thead class="bg-indigo-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">Guru</th>
                            <th class="px-4 py-3 text-left">Mapel</th>
                            <th class="px-4 py-3 text-left">Kelas</th>
                            <th class="px-4 py-3 text-left">Hari</th>
                            <th class="px-4 py-3 text-left">Jam</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-600"></tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function() {
            $('#scheduleTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.schedule.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'teacher', name: 'teacher' },
                    { data: 'subject', name: 'subject' },
                    { data: 'grade', name: 'grade' },
                    { data: 'day', name: 'day' },
                    { data: 'time', name: 'time' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ]
            });
        });

        $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        Swal.fire({
        title: 'Yakin hapus?',
        text: "Data jadwal akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
        }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
        url: "{{ url('admin/schedule') }}/" + id,
        type: "POST",
        data: {
        _method: "DELETE",
        _token: "{{ csrf_token() }}"
        },
        success: function(res) {
        if (res.success) {
        Swal.fire('Terhapus!', res.message, 'success');
        $('#scheduleTable').DataTable().ajax.reload();
        } else {
        Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
        }
        },
        error: function() {
        Swal.fire('Gagal!', 'Terjadi kesalahan server.', 'error');
        }
        });
        }
        })
        });
        </script>
    </x-slot>
</x-app-layout>