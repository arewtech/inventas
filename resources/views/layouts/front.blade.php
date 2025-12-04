<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.frontsides.style')
</head>

<body class="font-sans antialiased">
    <!-- Navigation -->
    @include('includes.frontsides.navigation')
    <!-- End Navigation -->

    <!-- Content -->
    @yield('content')
    <!-- End Content -->

    <!-- Footer -->
    @include('includes.frontsides.footer')
    <!-- End Footer -->

    <!-- Navigasi Cepat ke Atas -->
    <a href="#" class="scroll-to-top"><i class="bi bi-arrow-up-circle"></i></a>
    <!-- End Navigasi Cepat ke Atas -->

    <!-- Scripts -->
    @include('includes.frontsides.script')
    @stack('after:script')
    <!-- End Scripts -->
</body>

</html>
