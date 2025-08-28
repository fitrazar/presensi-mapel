<!-- Desktop Navigation -->
<nav class="hidden md:flex justify-between items-center 
    bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 
    text-white px-10 py-4 shadow-xl backdrop-blur-lg rounded-b-2xl">

    <!-- Logo -->
    <div class="text-2xl font-bold tracking-wide flex items-center space-x-2">
        <span class="text-yellow-300">📘</span>
        <span class="drop-shadow-md">Presensi Siswa</span>
    </div>

    <!-- Menu -->
    <div class="flex space-x-8 text-sm font-medium">
        <a href="{{ route('teacher.index') }}"
            class="flex items-center gap-2 hover:text-yellow-300 hover:scale-105 transition duration-200 ease-in-out">
            🏠 <span>Dashboard</span>
        </a>
        <a href="{{ route('teacher.schedule.index') }}"
            class="flex items-center gap-2 hover:text-yellow-300 hover:scale-105 transition duration-200 ease-in-out">
            📑 <span>Jadwal</span>
        </a>
        @if (Auth::user()->teacher->is_roommates)
        <a href="{{ route('teacher.report.index') }}"
            class="flex items-center gap-2 hover:text-yellow-300 hover:scale-105 transition duration-200 ease-in-out">
            📑 <span>Laporan</span>
        </a>

        <a href="{{ route('teacher.roommates.index') }}"
            class="flex items-center gap-2 hover:text-yellow-300 hover:scale-105 transition duration-200 ease-in-out">
            📅 <span>Mapel Kelas</span>
        </a>
        @endif
    </div>
</nav>

<!-- Header -->
<header class="bg-white shadow-sm flex justify-between items-center px-4 py-3 md:px-10 relative z-30">
    <h1 class="text-base md:text-lg font-semibold text-gray-700">
        Halo, {{ Auth::user()->teacher->name }} 👋
    </h1>

    <div class="flex items-center space-x-4">
        <!-- Avatar -->
        <div class="relative">
            <button id="profileBtn"
                class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 hover:scale-110 transition rounded-full text-white flex items-center justify-center font-semibold shadow-md">
                {{ strtoupper(substr(Auth::user()->teacher->name, 0, 1)) }}
            </button>

            <!-- Dropdown -->
            <div id="profileDropdown"
                class="hidden absolute right-0 top-12 bg-white border rounded-xl shadow-xl w-44 animate-fadeIn z-50">
                <ul class="text-sm text-gray-700">
                    <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer rounded-t-xl">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="flex items-center gap-2 text-red-600"
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
    class="fixed bottom-4 inset-x-4 bg-white border shadow-lg md:hidden flex justify-around items-center py-2 text-xs font-medium text-gray-600 z-40 rounded-2xl">
    <a href="{{ route('teacher.index') }}" class="flex flex-col items-center hover:text-blue-600 transition">
        <span class="text-lg">🏠</span>
        <span>Dashboard</span>
    </a>

    <a href="#" class="flex flex-col items-center hover:text-green-600 transition">
        <span class="text-lg">📑</span>
        <span>Laporan</span>
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