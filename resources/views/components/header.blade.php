@props(['search' => false, 'title' => ''])

<div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold">{{ $title }}</h1>
    @if ($search)
    <div class="flex items-center gap-2">
        {{-- <div class="relative">
            <input type="text" placeholder="Search..."
                class="pl-8 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div> --}}
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost btn-circle">
                <div class="indicator">
                    <i class="fas fa-bell text-gray-500 text-xl"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge badge-xs badge-error indicator-item"></span>
                    @endif
                </div>
            </label>
            <div tabindex="0" class="mt-3 z-[100] card card-compact dropdown-content w-80 bg-white shadow-xl">
                <div class="card-body">
                    <span class="font-bold text-lg">Notifikasi</span>

                    @forelse(auth()->user()->notifications->take(3) as $notification)
                    <div class="border-b py-2">
                        <div class="text-xs text-gray-700">{!! $notification->data['message'] ?? 'Tidak ada judul' !!}
                        </div>
                        <div class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                    </div>
                    @empty
                    <div class="text-sm text-gray-500">Tidak ada notifikasi</div>
                    @endforelse

                    <div class="pt-2">
                        <a href="{{ route('admin.notification.index') }}" class="btn btn-sm btn-outline w-full">Lihat
                            Semua</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif
</div>