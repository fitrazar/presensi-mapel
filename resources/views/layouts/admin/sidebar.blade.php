<!-- Mobile Sidebar Toggle -->
<button id="sidebarToggle"
    class="lg:hidden fixed top-4 left-4 z-50 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 text-white p-2 rounded-xl shadow-lg hover:scale-105 transition-transform">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<aside id="sidebar"
    class="bg-gradient-to-b from-blue-100 via-indigo-100 to-purple-100 w-64 fixed lg:relative -left-64 lg:left-0 top-0 bottom-0 min-h-full shadow-xl z-40 transition-all duration-300 overflow-y-auto rounded-r-3xl border-r border-indigo-200">

    <!-- Logo / Title -->
    <div class="p-6 text-2xl font-bold text-indigo-700 flex items-center gap-3 rounded-br-3xl">
        <i class="fas fa-chart-line text-indigo-600 text-xl"></i>
        Presensi
    </div>

    <!-- Navigation -->
    <nav class="px-4 pt-4 text-sm">
        <ul class="space-y-2 font-medium">

            <li>
                <a href="{{ route('admin.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-200
                        {{ Request::is('admin')
                        ? 'bg-indigo-200 text-indigo-900 font-semibold shadow-inner'
                        : 'hover:bg-indigo-100 text-gray-800' }}">
                    <i class="fas fa-home w-5 text-indigo-600"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- <li>
                <a href="{{ route('dashboard.penduduk.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-200
                        {{ Request::is('dashboard/penduduk*')
                        ? 'bg-pink-200 text-pink-900 font-semibold shadow-inner'
                        : 'hover:bg-pink-100 text-gray-800' }}">
                    <i class="fas fa-users w-5 text-pink-600"></i>
                    <span>Data Penduduk</span>
                </a>
            </li> --}}

            {{-- <li>
                <a href="{{ route('dashboard.user.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-200
                        {{ Request::is('dashboard/user*')
                        ? 'bg-teal-200 text-teal-900 font-semibold shadow-inner'
                        : 'hover:bg-teal-100 text-gray-800' }}">
                    <i class="fas fa-users w-5 text-teal-600"></i>
                    <span>Data User</span>
                </a>
            </li> --}}


            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center gap-3 p-3 rounded-xl transition-all duration-200 hover:bg-red-100 text-gray-800 hover:text-red-600">
                        <i class="fas fa-sign-out-alt w-5 text-red-500"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </li>

        </ul>
    </nav>
</aside>