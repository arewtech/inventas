<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- meta -->
    @include('includes.meta')
    <!-- end meta -->

    <!-- styles -->
    @include('includes.style')
    <!-- end styles -->
    @yield('css')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar Start -->
        @include('includes.sidebar')
        <!--  Sidebar End -->

        <!--  Main wrapper -->
        <div class="body-wrapper">

            <!--  Header Start -->
            @include('includes.header')
            <!--  Header End -->

            <!--  Content Start -->
            @yield('content')
            <!--  Content End -->

        </div>
    </div>

    <!--  Scripts -->
    @include('includes.script')
    <!--  End Scripts -->
    @yield('script')
</body>

</html>
