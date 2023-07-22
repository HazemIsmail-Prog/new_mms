<div style=" overflow:visible; border: 1px solid {{ $order->status_color }}"
    class="order{{ in_array($order->status_id, [3, 7]) ? '-non-dragable' : '' }}" id="order{{ $order->id }}"
    draggable='{{ in_array($order->status_id, [3, 7]) ? 'false' : 'true' }}'>
    <div class=" p-2 text-white" style="background: {{ $order->status_color }}">
        <div class="d-flex justify-content-between">
            <div>{{ $order->customer_name }}</div>
            <div>{{ $order->phone_number }}</div>
        </div>
        <div>{{ $order->address->full_address() }}</div>
    </div>
    <div class=" p-2">
        <table class="table table-sm table-striped table-borderless mb-0">
            <tr>
                <th nowrap>@lang('messages.creator')</th>
                <td>{{ $order->creator_name }}</td>
            </tr>
            <tr>
                <th nowrap>@lang('messages.order_number')</th>
                <td>
                    <div class=" d-flex justify-content-between align-content-center mb-0">
                        <div>{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</div>
                        @if ($order->unread_comments_count > 0)
                            <span wire:click="mark_comments_as_read({{ $order }})" style="font-size: 0.7rem;"
                                class="badge badge-danger">{{ $order->unread_comments_count }}</span>
                        @endif
                    </div>
                </td>
            </tr>
            @if ($order->order_description)
            <tr>
                <th nowrap>@lang('messages.order_description')</th>
                <td>{{ $order->order_description }}</td>
            </tr>
                
            @endif
            @if ($order->notes)
                <tr>
                    <th nowrap>@lang('messages.notes')</th>
                    <td>{{ $order->notes }}</td>
                </tr>
            @endif
            @if (!in_array($order->status_id, [3, 7]))
                <tr>
                    <th nowrap>@lang('messages.technician')</th>
                    <td>
                        <select wire:loading.attr="disabled"
                            wire:model="change_order_technician.{{ $order->id }}.technician_id"
                            class=" form-control form-control-sm">
                            <option disabled selected value="">---</option>
                            @foreach ($this->technicians->sortBy('name') as $technician)
                                <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endif

        </table>
    </div>
    <div class=" d-flex justify-content-between align-items-center mb-0 p-2"
        style="border-top: 1px solid {{ $order->status_color }}">
        <button class="btn btn-sm" target="popup" onclick="popupWindow('{{ route('orders.show', $order) }}', 'test');">
            <svg style="width: 15px;height: 15px">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-featured-playlist') }}"></use>
            </svg>
        </button>
        @if ($order->status_id != 5)
            <form class="d-inline m-0"
                wire:submit.prevent="change_technician({{ $order->id }}, 'hold' , {{ $order->technician_id }}, [])">
                <button type="submit" class=" btn btn-sm text-dark"
                    onclick="return confirm('{{ __('messages.hold_order_confirmation') }}')">
                    {{ __('messages.on_hold') }}
                </button>
            </form>
        @endif
        <form class="d-inline m-0"
            wire:submit.prevent="change_technician({{ $order->id }}, 'cancel',null , [])">
            <button type="submit" class=" btn btn-sm text-danger"
                onclick="return confirm('{{ __('messages.cancel_order_confirmation') }}')">
                <svg style="width: 15px;height: 15px">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                    </use>
                </svg>
            </button>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        function popupWindow(url, windowName) {
            const w = window.outerWidth / 1.2;
            const h = window.outerHeight / 1.2;
            const y = window.top.outerHeight / 2 + window.top.screenY - (h / 2);
            const x = window.top.outerWidth / 2 + window.top.screenX - (w / 2);
            return window.open(url, windowName,
                `toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=${w}, height=${h}, top=${y}, left=${x}`
            );
        }
    </script>
@endpush
