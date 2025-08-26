@section('title', 'Data User')
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
            <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 gap-3">
                <h2 class="text-2xl font-bold text-gray-700">Data Admin</h2>
                <a href="{{ route('admin.admin.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
                    + Tambah Data
                </a>
            </div>

            <!-- Filter -->
            <div class="mb-6 flex flex-col sm:flex-row gap-3">
                <select id="filter-gender"
                    class="border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Filter Gender --</option>
                    <option value="Laki - Laki">Laki - Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <button id="reset-filter"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg shadow text-sm font-medium">
                    Reset
                </button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table id="adminTable" class="min-w-full text-sm text-left border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Photo</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Phone</th>
                            <th class="px-4 py-2">Gender</th>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2 text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(function () {
                let table = $('#adminTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('admin.admin.index') }}",
                        data: function (d) {
                            d.gender = $('#filter-gender').val()
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'photo', name: 'photo', orderable: false, searchable: false },
                        { data: 'name', name: 'name' },
                        { data: 'phone', name: 'phone' },
                        { data: 'gender', name: 'gender' },
                        { data: 'user.username', name: 'user.username' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]
                });

                // Filter event
                $('#filter-gender').change(function(){
                    table.draw();
                });

                // Reset filter
                $('#reset-filter').click(function(){
                    $('#filter-gender').val('');
                    table.draw();
                });
            });

            $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            Swal.fire({
            title: 'Yakin hapus?',
            text: "Data admin akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
            }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
            url: "{{ url('admin/admin') }}/" + id,
            type: "POST",
            data: {
            _method: "DELETE",
            _token: "{{ csrf_token() }}"
            },
            success: function(res) {
            if (res.success) {
            Swal.fire('Terhapus!', res.message, 'success');
            $('#adminTable').DataTable().ajax.reload();
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