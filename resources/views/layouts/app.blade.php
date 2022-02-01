<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/eventHandler.js') }}"></script>
    @yield('event')
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- Icon Styles --}}
    {{-- Credit to: https://fontawesome.com/ --}}
    <link href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet">
    {{-- favicon --}}
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
</head>
<body>
    <div class="app">
        @include('layouts.subviews.navigation')
        <div class="wrapper">
            @include('layouts.subviews.info.error.list')
            @yield('content')
        </div>
        <footer class="footer-nav">
            @include('layouts.subviews.footer')
        </footer>
    </div>
    <!-- Scripts to load at the end -->
    @yield('scripts')
    <script src="{{ asset('js/error/eventHandler.js') }}"></script>
</body>
</html>
