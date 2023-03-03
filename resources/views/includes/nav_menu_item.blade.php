@can($item['permission_name'])
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{$item['route']}}">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="{{$item['icon']}}"></use>
            </svg>
            {{ $item['display_name'] }}
            {{-- <span class="badge badge-pill badge-info">@lang('messages.new')</span> --}}
        </a>
    </li>
@endcan