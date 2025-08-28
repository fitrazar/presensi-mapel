@section('title', 'Jadwal Mengajar')
<x-app-layout>
    <div class="py-10 max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-indigo-600">📅 Jadwal Mengajar Saya</h1>
            <p class="text-gray-600 mt-2">Berikut jadwal mengajar Anda yang sudah diurutkan berdasarkan hari dan jam.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($schedules as $schedule)
            @php
            $today = ucfirst(\Carbon\Carbon::now()->locale('id')->dayName);
            $now = \Carbon\Carbon::now();
            $start = \Carbon\Carbon::parse($schedule->start_time);
            $end = \Carbon\Carbon::parse($schedule->end_time);

            $isNow = ($today == $schedule->day) && $now->between($start, $end);
            $isUpcoming = ($today == $schedule->day) && $start->greaterThan($now);

            $status = $isNow ? 'Sedang Berlangsung' : ($isUpcoming ? 'Belum Mulai' : 'Selesai');
            $statusColor = $isNow ? 'bg-green-100 text-green-700' : ($isUpcoming ? 'bg-yellow-100 text-yellow-700' :
            'bg-gray-200 text-gray-600');
            @endphp

            <div
                class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-sm font-semibold">
                            {{ $schedule->day }}
                        </span>
                        <span class="text-sm font-bold text-gray-700">
                            {{ $start->format('H:i') }} - {{ $end->format('H:i') }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold mt-4 text-gray-800">{{ $schedule->subjectTeacher->subject->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">Kelas: {{ $schedule->subjectTeacher->grade->full_class_name ??
                        '-' }}</p>

                    <div class="mt-6 flex justify-between items-center gap-2 flex-wrap">
                        <span class="text-xs px-3 py-1 rounded-lg font-medium {{ $statusColor }}">
                            {{ $status }}
                        </span>

                        @if($isNow)
                        <a href="{{ route('teacher.attendance.index', $schedule->id) }}" class="btn btn-primary">
                            Presensi
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="bg-gray-50 text-center py-12 rounded-2xl shadow-sm border border-gray-200">
                    <p class="text-gray-500">😕 Belum ada jadwal mengajar untuk Anda.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>