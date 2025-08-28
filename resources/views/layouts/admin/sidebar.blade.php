<!-- Mobile Sidebar Toggle -->
<button id="sidebarToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
           text-white p-3 rounded-xl shadow-lg hover:scale-110 hover:rotate-6 transition-transform duration-300">
    <i class="fas fa-bars text-lg"></i>
</button>

<!-- Sidebar -->
<aside id="sidebar" class="backdrop-blur-2xl bg-gradient-to-b from-indigo-100/70 via-purple-100/70 to-pink-100/70
           w-64 fixed lg:relative -left-64 lg:left-0 top-0 bottom-0 min-h-full shadow-2xl
           transition-all duration-500 ease-in-out overflow-y-auto rounded-r-3xl border-r border-white/40 z-40">

    <!-- Logo / Title -->
    <div class="p-6 text-2xl font-extrabold text-indigo-700 flex items-center gap-3 border-b border-indigo-200/50">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-3 rounded-xl shadow-md text-white">
            <i class="fas fa-book-reader text-lg"></i>
        </div>
        <span class="tracking-wide">Presensi</span>
    </div>

    <!-- Navigation -->
    <nav class="px-4 pt-6 text-sm">
        <ul class="space-y-3 font-medium">

            <!-- Section: Main -->
            <p class="px-3 text-xs uppercase tracking-wider text-gray-500">Main Menu</p>

            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group
                          {{ Request::is('admin')
                              ? 'bg-gradient-to-r from-indigo-400 to-indigo-600 text-white shadow-lg scale-[1.02]'
                              : 'hover:bg-indigo-100 text-gray-800' }}">
                    <i
                        class="fas fa-home w-5 {{ Request::is('admin') ? 'text-white' : 'text-indigo-600 group-hover:text-indigo-700' }}"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Data Guru -->
            <li>
                <a href="{{ route('admin.teacher.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group
                          {{ Request::is('admin/teacher*')
                              ? 'bg-gradient-to-r from-purple-400 to-purple-600 text-white shadow-lg scale-[1.02]'
                              : 'hover:bg-purple-100 text-gray-800' }}">
                    <i
                        class="fas fa-chalkboard-teacher w-5 {{ Request::is('admin/teacher*') ? 'text-white' : 'text-purple-600 group-hover:text-purple-700' }}"></i>
                    <span>Data Guru</span>
                </a>
            </li>

            <!-- Data Siswa -->
            <li>
                <a href="{{ route('admin.student.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group
                          {{ Request::is('admin/student*')
                              ? 'bg-gradient-to-r from-pink-400 to-pink-600 text-white shadow-lg scale-[1.02]'
                              : 'hover:bg-pink-100 text-gray-800' }}">
                    <i
                        class="fas fa-user-graduate w-5 {{ Request::is('admin/student*') ? 'text-white' : 'text-pink-600 group-hover:text-pink-700' }}"></i>
                    <span>Data Siswa</span>
                </a>
            </li>

            <!-- Section: Academic -->
            <p class="px-3 mt-4 text-xs uppercase tracking-wider text-gray-500">Akademik</p>

            <!-- Data Mapel -->
            <li>
                <a href="{{ route('admin.subject.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group
                          {{ Request::is('admin/subject*')
                              ? 'bg-gradient-to-r from-yellow-400 to-yellow-600 text-white shadow-lg scale-[1.02]'
                              : 'hover:bg-yellow-100 text-gray-800' }}">
                    <i
                        class="fas fa-book-open w-5 {{ Request::is('admin/subject*') ? 'text-white' : 'text-yellow-600 group-hover:text-yellow-700' }}"></i>
                    <span>Data Mapel</span>
                </a>
            </li>

            <!-- Jadwal -->
            <li>
                <a href="{{ route('admin.schedule.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group
                          {{ Request::is('admin/schedule*')
                              ? 'bg-gradient-to-r from-amber-400 to-amber-600 text-white shadow-lg scale-[1.02]'
                              : 'hover:bg-amber-100 text-gray-800' }}">
                    <i
                        class="fas fa-calendar-alt w-5 {{ Request::is('admin/schedule*') ? 'text-white' : 'text-amber-600 group-hover:text-amber-700' }}"></i>
                    <span>Jadwal Mapel</span>
                </a>
            </li>

            <!-- Presensi -->
            <li>
                <a href="{{ route('admin.attendance.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group
                          {{ Request::is('admin/attendance*')
                              ? 'bg-gradient-to-r from-green-400 to-green-600 text-white shadow-lg scale-[1.02]'
                              : 'hover:bg-green-100 text-gray-800' }}">
                    <i
                        class="fas fa-clipboard-check w-5 {{ Request::is('admin/attendance*') ? 'text-white' : 'text-green-600 group-hover:text-green-700' }}"></i>
                    <span>Presensi</span>
                </a>
            </li>

            <!-- Laporan -->
            <li>
                <a href="{{ route('admin.report.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group
                          {{ Request::is('admin/report*')
                              ? 'bg-gradient-to-r from-cyan-400 to-cyan-600 text-white shadow-lg scale-[1.02]'
                              : 'hover:bg-cyan-100 text-gray-800' }}">
                    <i
                        class="fas fa-file-alt w-5 {{ Request::is('admin/report*') ? 'text-white' : 'text-cyan-600 group-hover:text-cyan-700' }}"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <!-- Section: System -->
            <p class="px-3 mt-4 text-xs uppercase tracking-wider text-gray-500">Sistem</p>

            <!-- Data User -->
            <li>
                <a href="{{ route('admin.admin.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group
                          {{ Request::is('admin/admin*')
                              ? 'bg-gradient-to-r from-teal-400 to-teal-600 text-white shadow-lg scale-[1.02]'
                              : 'hover:bg-teal-100 text-gray-800' }}">
                    <i
                        class="fas fa-user-shield w-5 {{ Request::is('admin/admin*') ? 'text-white' : 'text-teal-600 group-hover:text-teal-700' }}"></i>
                    <span>Data User</span>
                </a>
            </li>

            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300
                              hover:bg-red-100 text-gray-800 hover:text-red-600">
                        <i class="fas fa-sign-out-alt w-5 text-red-500"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </li>

        </ul>
    </nav>
</aside>