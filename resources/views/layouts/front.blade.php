<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.frontsides.style')
    @stack('after:css')
</head>

<body class="font-sans antialiased">
    @if (url()->current() == route('home'))
        <!-- Navigation -->
        @include('includes.frontsides.navigation')
        <!-- End Navigation -->
    @endif

    <!-- Content -->
    @yield('content')
    <!-- End Content -->

    @if (url()->current() == route('home'))
        <!-- Footer -->
        @include('includes.frontsides.footer')
        <!-- End Footer -->
    @endif

    <!-- Navigasi Cepat ke Atas -->
    <a href="#" class="scroll-to-top"><i class="bi bi-arrow-up-circle"></i></a>
    <!-- End Navigasi Cepat ke Atas -->

    <!-- Scripts -->
    @include('includes.frontsides.script')
    @stack('after:script')
    <!-- End Scripts -->
</body>

</html>
