<!-- Desktop Navigation -->
<nav
    class="hidden md:flex justify-between items-center bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 text-white px-8 py-4 shadow-lg backdrop-blur-md">
    <div class="text-2xl font-bold tracking-wide flex items-center space-x-2">
        <span>📘</span>
        <span>Presensi Siswa</span>
    </div>
    <div class="flex space-x-8 text-sm font-medium">
        <a href="{{ route('teacher.index') }}" class="hover:text-yellow-300 transition duration-200 ease-in-out">🏠
    </div>
</nav>

<!-- Header -->
<header class="bg-white shadow-sm flex justify-between items-center px-4 py-3 md:px-8 relative z-30">
    <h1 class="text-base md:text-lg font-semibold text-gray-700">Halo, {{ Auth::user()->teacher->nama }} 👋</h1>

    <div class="flex items-center space-x-4">

        <!-- Notifikasi -->
        <div class="relative group">
            <button
                class="relative w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-blue-100 transition">
                <i class="fas fa-bell text-gray-500 text-xl"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                @endif
            </button>

            <!-- Dropdown -->
            <div
                class="hidden group-hover:flex flex-col absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border text-sm z-40 p-4 space-y-2">
                <span class="font-bold text-lg mb-2 text-gray-800">🔔 Notifikasi</span>
                @forelse(auth()->user()->notifications->take(4) as $notification)
                <div class="border-b pb-2">
                    <p class="text-gray-700">{{ $notification->data['message'] }}</p>
                    <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                </div>
                @empty
                <p class="text-gray-500">Tidak ada notifikasi</p>
                @endforelse
                <a href="{{ route('mahasiswa.notification.index') }}"
                    class="text-center text-blue-600 hover:underline text-sm mt-2">Lihat Semua</a>
            </div>
        </div>

        <!-- Avatar -->
        <div class="relative">
            <button id="profileBtn"
                class="w-9 h-9 bg-blue-600 hover:bg-blue-700 transition rounded-full text-white flex items-center justify-center font-semibold">
                {{ strtoupper(substr(Auth::user()->teacher->nama, 0, 1)) }}
            </button>

            <!-- Dropdown -->
            <div id="profileDropdown"
                class="hidden absolute right-0 top-12 bg-white border rounded shadow-md w-40 animate-fadeIn z-50">
                <ul class="text-sm text-gray-700">
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();this.closest('form').submit();">
                                🚪 Logout
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</header>

<!-- Bottom Mobile Navigation -->
<nav
    class="fixed bottom-0 inset-x-0 bg-white border-t shadow-md md:hidden flex justify-around items-center py-2 text-xs font-medium text-gray-600 z-40">
    <a href="{{ route('teacher.index') }}" class="flex flex-col items-center hover:text-blue-600 transition">
        <span class="text-lg">🏠</span>
        <span>Dashboard</span>
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}" class="flex flex-col items-center hover:text-red-500 transition"
            onclick="event.preventDefault();this.closest('form').submit();">
            <span class="text-lg">🚪</span>
            <span>Logout</span>
        </a>
    </form>
</nav>