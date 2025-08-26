@section('title', 'Detail Admin')
<x-app-layout>
    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <!-- Header -->
            <div
                class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-8 flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0">
                    <img src="{{ $admin->photo ? asset('storage/'.$admin->photo) : 'https://ui-avatars.com/api/?name='.$admin->name.'&background=random' }}"
                        alt="Foto Admin" class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h2 class="text-2xl font-bold text-white">{{ $admin->name }}</h2>
                    <p class="text-indigo-100">Username: <span class="font-semibold">{{ $admin->user->username }}</span>
                    </p>
                    <p class="text-indigo-100">Bergabung: {{ $admin->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Body -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-500 mb-1">Nama Lengkap</h3>
                    <p class="text-lg text-gray-700">{{ $admin->name }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-500 mb-1">Nomor HP</h3>
                    <p class="text-lg text-gray-700">{{ $admin->phone ?? '-' }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-500 mb-1">Jenis Kelamin</h3>
                    <p class="text-lg text-gray-700">{{ $admin->gender }}</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-500 mb-1">Username</h3>
                    <p class="text-lg text-gray-700">{{ $admin->user->username }}</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-100 flex justify-end space-x-3">
                <a href="{{ route('admin.admin.index') }}"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium shadow">
                    Kembali
                </a>
                <a href="{{ route('admin.admin.edit', $admin->id) }}"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium shadow">
                    Edit
                </a>
            </div>
        </div>

    </div>
</x-app-layout>