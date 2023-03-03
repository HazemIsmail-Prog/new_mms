@can($item['permission_name'])
    <li class="c-sidebar-nav-title text-info">
        {{ $item['display_name'] }}
    </li>
    @foreach ($item['childs'] as $item)
        @switch($item['type'])
            @case('nav_menu_item')
                @include('includes.nav_menu_item')
            @break
            @case('menu_dropdown')
                @include('includes.menu_dropdown')
            @break                                  
        @endswitch
    @endforeach
@endcan