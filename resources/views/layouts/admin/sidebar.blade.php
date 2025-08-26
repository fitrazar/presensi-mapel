<!-- Mobile Sidebar Toggle -->
<button id="sidebarToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 
           text-white p-3 rounded-xl shadow-lg hover:scale-110 hover:rotate-6 transition-transform duration-300">
    <i class="fas fa-bars text-lg"></i>
</button>

<!-- Sidebar -->
<aside id="sidebar" class="backdrop-blur-xl bg-gradient-to-b from-indigo-50/80 via-purple-50/80 to-pink-50/80 
           w-64 fixed lg:relative -left-64 lg:left-0 top-0 bottom-0 min-h-full shadow-2xl 
           transition-all duration-500 ease-in-out overflow-y-auto rounded-r-3xl border-r border-indigo-200/50 z-40">

    <!-- Logo / Title -->
    <div class="p-6 text-2xl font-extrabold text-indigo-700 flex items-center gap-3">
        <i class="fas fa-book-reader text-indigo-600 text-2xl"></i>
        <span class="tracking-wide">Presensi</span>
    </div>

    <!-- Navigation -->
    <nav class="px-4 pt-4 text-sm">
        <ul class="space-y-2 font-medium">

            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300
                          {{ Request::is('admin') 
                              ? 'bg-indigo-200/80 text-indigo-900 font-semibold shadow-inner ring-2 ring-indigo-400' 
                              : 'hover:bg-indigo-100 text-gray-800' }}">
                    <i class="fas fa-home w-5 text-indigo-600"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Data Guru -->
            <li>
                <a href="{{ route('admin.teacher.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300
                          {{ Request::is('admin/teacher*') 
                              ? 'bg-purple-200/80 text-purple-900 font-semibold shadow-inner ring-2 ring-purple-400' 
                              : 'hover:bg-purple-100 text-gray-800' }}">
                    <i class="fas fa-chalkboard-teacher w-5 text-purple-600"></i>
                    <span>Data Guru</span>
                </a>
            </li>

            <!-- Data Siswa -->
            <li>
                <a href="{{ route('admin.student.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300
                          {{ Request::is('admin/student*') 
                              ? 'bg-pink-200/80 text-pink-900 font-semibold shadow-inner ring-2 ring-pink-400' 
                              : 'hover:bg-pink-100 text-gray-800' }}">
                    <i class="fas fa-user-graduate w-5 text-pink-600"></i>
                    <span>Data Siswa</span>
                </a>
            </li>

            <!-- Data Mapel -->
            <li>
                <a href="{{ route('admin.subject.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300
                          {{ Request::is('admin/subject*') 
                              ? 'bg-yellow-200/80 text-yellow-900 font-semibold shadow-inner ring-2 ring-yellow-400' 
                              : 'hover:bg-yellow-100 text-gray-800' }}">
                    <i class="fas fa-book-open w-5 text-yellow-600"></i>
                    <span>Data Mapel</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.schedule.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300
                          {{ Request::is('admin/schedule*') 
                              ? 'bg-yellow-200/80 text-yellow-900 font-semibold shadow-inner ring-2 ring-yellow-400' 
                              : 'hover:bg-yellow-100 text-gray-800' }}">
                    <i class="fas fa-book-open w-5 text-yellow-600"></i>
                    <span>Jadwal Mapel</span>
                </a>
            </li>

            <!-- Data User -->
            <li>
                <a href="{{ route('admin.admin.index') }}" class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300
                          {{ Request::is('admin/admin*') 
                              ? 'bg-teal-200/80 text-teal-900 font-semibold shadow-inner ring-2 ring-teal-400' 
                              : 'hover:bg-teal-100 text-gray-800' }}">
                    <i class="fas fa-user-shield w-5 text-teal-600"></i>
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