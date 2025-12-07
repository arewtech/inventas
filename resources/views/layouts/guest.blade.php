<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- meta -->
    @include('includes.meta')
    <!-- end meta -->

    <!-- styles -->
    @include('includes.style')
    <!-- end styles -->

</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            @yield('content')
        </div>
    </div>

    <!--  Scripts -->
    @include('includes.script')
    <!--  End Scripts -->
</body>

</html>
