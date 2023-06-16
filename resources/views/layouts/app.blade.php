<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="nav-fixed">
<x-app-top-bar/>
<div id="layoutSidenav">
    {{--        @livewire('navigation-menu')--}}
    <x-app-side-bar/>

    <div id="layoutSidenav_content">
        <x-banner/>
        <main>
            @if (isset($header))
                {{$header}}
            @endif
            <!-- Main page content-->
            <div class="container-xl px-4 mt-4">
                {{ $slot }}
            </div>
        </main>
        <footer class="footer-admin mt-auto footer-light">
            <div class="container-xl px-4">
                <div class="row">
                    <div class="col-md-6 small">Copyright &copy; {{config('app.name')}} 2023</div>
                    <div class="col-md-6 text-md-end small">
                        <a href="{{route('front.privacy')}}">Privacy Policy</a>
                        &middot;
                        <a href="{{route('front.terms')}}">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
@stack('modals')

@livewireScripts
</body>
</html>
