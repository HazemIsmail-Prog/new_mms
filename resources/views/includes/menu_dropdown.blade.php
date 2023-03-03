@can($item['permission_name'])
    <li class="c-sidebar-nav-dropdown">
        <a class="c-sidebar-nav-dropdown-toggle" href="#">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="{{$item['icon']}}"></use>
            </svg>
            {{ $item['display_name'] }}
        </a>
        <ul class="c-sidebar-nav-dropdown-items">
            @foreach ($item['childs'] as $item)
                @include('includes.nav_menu_item')
            @endforeach
        </ul>
    </li>
@endcan