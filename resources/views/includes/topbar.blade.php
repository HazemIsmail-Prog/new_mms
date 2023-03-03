<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
        data-class="c-sidebar-show">
        <svg class="c-icon c-icon-lg">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
        </svg>
    </button>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
        data-class="c-sidebar-lg-show" responsive="true">
        <svg class="c-icon c-icon-lg">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
        </svg>
    </button>

    <ul class="c-header-nav {{ config('app.locale') == 'ar' ? 'mr-auto ml-4' : 'ml-auto mr-4' }}">
        {{--        add "d-md-down-none" to hide in mobile screen --}}
        {{--        <li class="c-header-nav-item mx-2"> --}}
        {{--            <a class="c-header-nav-link" href="#"> --}}
        {{--                <svg class="c-icon"> --}}
        {{--                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-bell')}}"></use> --}}
        {{--                </svg> --}}
        {{--            </a> --}}
        {{--        </li> --}}
        {{--        add "d-md-down-none" to hide in mobile screen --}}
        {{--        <li class="c-header-nav-item mx-2"> --}}
        {{--            <a class="c-header-nav-link" href="#"> --}}
        {{--                <svg class="c-icon"> --}}
        {{--                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-list-rich')}}"></use> --}}
        {{--                </svg> --}}
        {{--            </a> --}}
        {{--        </li> --}}
        {{--        add "d-md-down-none" to hide in mobile screen --}}
        {{-- <li class="c-header-nav-item mx-2"> --}}
        {{-- <a class="c-header-nav-link" href="#"> --}}
        {{-- <svg class="c-icon"> --}}
        {{-- <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-envelope-open')}}"></use> --}}
        {{-- </svg> --}}
        {{-- </a> --}}
        {{-- </li> --}}


        {{-- @livewire('chatting-index') --}}



        <a class="btn btn-ghost-dark" rel="alternate" hreflang="{{ config('app.locale') == 'ar' ? 'en' : 'ar' }}"
            href="{{ LaravelLocalization::getLocalizedURL(config('app.locale') == 'ar' ? 'en' : 'ar', null, [], true) }}">
            {{ config('app.locale') == 'ar' ? 'En' : 'ع' }}
        </a>

        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                aria-expanded="false">
                <div class="c-avatar">
                    <img class="c-avatar-img" src="{{ asset('vendors/@coreui/img/avatars/default.jpg') }}"
                        alt="user@email.com">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right py-0">
                <div class="dropdown-header bg-light py-2">
                    <strong>Account</strong>
                </div>
                {{-- <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}" href="#">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-bell') }}"></use>
                    </svg>
                    <div class="px-2">Updates</div>
                    <span class="badge badge-info ml-auto">42</span>
                </a> --}}

                {{-- <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}" href="#">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-envelope-open') }}"></use>
                    </svg>
                    <div class="px-2">Messages</div>
                    <span class="badge badge-success ml-auto">42</span>
                </a> --}}
                {{-- <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}" href="#">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-task') }}"></use>
                    </svg>
                    <div class="px-2">Tasks</div>
                    <span class="badge badge-danger ml-auto">42</span>
                </a> --}}
                {{-- <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}" href="#">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-comment-square') }}"></use>
                    </svg>
                    <div class="px-2">Comments</div>
                    <span class="badge badge-warning ml-auto">42</span>
                </a> --}}
                {{-- <div class="dropdown-header bg-light py-2">
                    <strong>Settings</strong>
                </div> --}}
                <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}" href="#">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                    </svg>
                    <div class="px-2">Profile</div>
                </a>
                {{-- <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}" href="#">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-settings') }}"></use>
                    </svg>
                    <div class="px-2">Settings</div>
                </a> --}}
                {{-- <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}" href="#">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-credit-card') }}"></use>
                    </svg>
                    <div class="px-2">Payments</div>
                    <span class="badge badge-secondary ml-auto">42</span>
                </a> --}}
                {{-- <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}" href="#">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-file') }}"></use>
                    </svg>
                    <div class="px-2">Projects</div>
                    <span class="badge badge-primary ml-auto">42</span>
                </a> --}}
                <div class="dropdown-divider m-0"></div>
                {{-- <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}" href="#">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-lock-locked') }}"></use>
                    </svg>
                    <div class="px-2">Lock Account</div>
                </a> --}}
                <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}"
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
                    </svg>
                    <div class="px-2">Logout</div>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</header>
