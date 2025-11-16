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
    @yield('content')

    <!--  Scripts -->
    @include('includes.script')
    <!--  End Scripts -->
</body>

</html>
