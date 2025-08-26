<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel')) - {{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo2.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/solid.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/brands.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTableTailwind.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <style>
        html {
            scroll-behavior: smooth;
        }

        #scrollToTopBtn {
            cursor: pointer;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins antialiased">
    @role('admin')
    <div class="min-h-screen bg-gray-50 text-gray-800">
        <div class="flex min-h-screen">
            @include('layouts.admin.sidebar')

            <!-- Page Content -->
            <main class="flex-1 p-4 md:p-6 space-y-6 ml-0 transition-all duration-300">
                {{ $slot }}
            </main>
        </div>
    </div>

    <button id="scrollToTopBtn"
        class="fixed bottom-0 right-0 z-50 p-3 bg-blue-600 text-white rounded-full shadow-lg hidden hover:bg-blue-700 transition-all duration-300">
        <i class="fas fa-arrow-up"></i>
    </button>
    @else
    <div class="bg-gray-100 text-gray-800 flex flex-col min-h-screen relative">
        @include('layouts.teacher.navbar')

        <!-- Page Content -->
        <main class="flex-1 p-4 md:p-8 space-y-6 pb-24 md:pb-8">
            {{ $slot }}
        </main>
    </div>
    @endrole

    <script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/js/all.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/js/solid.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/js/brands.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/js/fontawesome.js') }}"></script>
    <script src="{{ asset('assets/js/dataTable.js') }}"></script>
    <script src="{{ asset('assets/js/dataTableTailwind.js') }}"></script>
    <script src="{{ asset('assets/js/webcam.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        new DataTable('#myTable');
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        // Mobile sidebar toggle
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('-left-64');
                sidebar.classList.toggle('left-0');

                const main = document.querySelector('main');
                main.classList.toggle('ml-0');
                main.classList.toggle('ml-64');
            });
    </script>
    <script>
        const scrollToTopBtn = document.getElementById("scrollToTopBtn");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 200) {
            scrollToTopBtn.classList.remove("hidden");
        } else {
            scrollToTopBtn.classList.add("hidden");
        }
    });

    scrollToTopBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
    </script>

    @if (isset($script))
    {{ $script }}
    @endif
</body>

</html>