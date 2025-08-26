@section('title', 'Detail Siswa')
<x-app-layout>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-10 px-4">
        <div class="max-w-4xl w-full bg-white shadow-xl rounded-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white">
                <h2 class="text-2xl font-bold">Detail Siswa</h2>
                <p class="text-sm text-indigo-100">Informasi lengkap mengenai siswa</p>
            </div>

            <!-- Content -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Side -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-gray-600 text-sm">Nama Lengkap</h3>
                        <p class="text-lg font-semibold text-gray-800">{{ $student->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-gray-600 text-sm">NISN</h3>
                        <p class="text-lg font-semibold text-gray-800">{{ $student->nisn ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-gray-600 text-sm">Jenis Kelamin</h3>
                        <p class="text-lg font-semibold text-gray-800">{{ $student->gender }}</p>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-gray-600 text-sm">Kelas</h3>
                        <p class="text-lg font-semibold text-gray-800">{{ $student->grade->full_class_name }}</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-100 flex justify-between items-center">
                <a href="{{ route('admin.student.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
                    Kembali
                </a>
                <a href="{{ route('admin.student.edit', $student->id) }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Edit Data
                </a>
            </div>
        </div>
    </div>
</x-app-layout>