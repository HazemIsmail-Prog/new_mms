<!doctype html>
<html lang="{{config('app.locale') == 'ar' ? 'ar' : 'en'}}" dir="{{config('app.locale') == 'ar' ? 'rtl' : 'ltr'}}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('includes.links')
    @yield('links')
    @yield('styles')
    @yield('title')
    <title>{{ config('app.name', 'Laravel') }}</title>
    @livewireStyles
</head>
<body class="c-app">
@include('includes.sidebar')
<div class="c-wrapper c-fixed-components">
    @include('includes.topbar')
    <div class="c-body">
        <main class="c-main">
            <div class="container-fluid">
                <div>
                    @yield('content')
                    {{-- @livewire('chatting-index') --}}
                    {{-- {{ $slot }} --}}
                </div>
            </div>
        </main>
        @include('includes.footer')
    </div>
</div>
@include('includes.scripts')
@stack('scripts')
@livewireScripts
</body>
</html>
