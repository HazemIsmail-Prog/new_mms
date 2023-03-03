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
    <title>{{ config('app.name', 'Laravel') }}</title>
    @livewireStyles
</head>
<body class="c-app">
<div class="c-wrapper c-fixed-components">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">

        <ul class="c-header-nav {{config('app.locale') == 'ar' ? 'mr-auto ml-4' : 'ml-auto mr-4'}}">

            <a class="btn btn-ghost-dark" rel="alternate" hreflang="{{config('app.locale') == 'ar' ? 'en' : 'ar'}}"
               href="{{ LaravelLocalization::getLocalizedURL(config('app.locale') == 'ar' ? 'en' : 'ar', null, [], true) }}">
                {{config('app.locale') == 'ar' ? 'En' : 'ع'}}
            </a>
            <a class="btn btn-ghost-dark" href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <svg class="c-icon">
                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout')}}"></use>
                </svg>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>
    </header>
    <div class="c-body">
        <main class="c-main">
            <div class="container-fluid">
                {{-- @yield('content') --}}
                {{ $slot }}
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
