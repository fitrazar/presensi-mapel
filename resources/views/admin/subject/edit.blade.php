@section('title', 'Edit Mapel')
<x-app-layout>
    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-2xl p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-700">Edit Data Mapel</h2>

            <form method="POST" action="{{ route('admin.subject.update', $subject->id) }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name & Kode -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Mapel</label>
                        <input type="text" name="name" value="{{ old('name', $subject->name) }}" required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Mapel</label>
                        <input type="text" name="code" value="{{ old('code', $subject->code) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('code') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <a href="{{ route('admin.subject.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg mr-2">Batal</a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>