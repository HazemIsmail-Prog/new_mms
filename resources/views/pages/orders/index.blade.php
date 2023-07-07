@extends('layouts.app')

@section('title')
    <title>@lang('messages.orders')</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>{{ __('messages.orders') }}</div>
                    <div>{{ __('messages.results_number') }} = {{ $orders->total() }}</div>
                </div>

                <div class="card-body">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                    @endif

                    @include('pages.orders.searching_form')

                    <div class="table-responsive">

                        <table class="table table-hover table-outline mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">@lang('messages.order_number')</th>
                                    <th class="text-center">@lang('messages.created_at')</th>
                                    <th class="text-center">@lang('messages.estimated_start_date')</th>
                                    <th class="text-center">@lang('messages.status')</th>
                                    <th class="text-center">@lang('messages.department')</th>
                                    <th class="text-center">@lang('messages.technician')</th>
                                    <th class="text-center">@lang('messages.completed_date')</th>
                                    <th class="text-center">@lang('messages.customer')</th>
                                    <th class="text-center">@lang('messages.actions')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($orders as $order)
                                    <tr>
                                        <td class="text-center" nowrap>
                                            {{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="text-center" nowrap>
                                            <div class="small badge badge-pill badge-dark">{{ @$order->creator->name }}
                                            </div>
                                            <div>{{ date('d-m-Y', strtotime($order->created_at)) }}</div>
                                            <div class="small">{{ date('H:i', strtotime($order->created_at)) }}</div>
                                        </td>
                                        <td class="text-center" nowrap>
                                            {{ date('d-m-Y', strtotime($order->estimated_start_date)) }}</td>
                                        <td style="color: {{ $order->status->color }}" class="text-center" nowrap>
                                            {{ @$order->status->name }}</td>
                                        <td class="text-center" nowrap>{{ @$order->department->name }}</td>
                                        <td class="text-center" nowrap>
                                            {{ @$order->technician->name ?? __('messages.unassigned') }}</td>
                                        <td class="text-center" nowrap>
                                            @if ($order->completed_at)
                                                <div>{{ date('d-m-Y', strtotime($order->completed_at)) }}</div>
                                                <div class="small">{{ date('H:i', strtotime($order->completed_at)) }}</div>
                                            @endif
                                        </td>
                                        <td nowrap>
                                            <div>{{ @$order->customer->name }}</div>
                                            <div>{{ $order->phone->number }}</div>
                                            <a class="text-decoration-none text-dark" target="_blank"
                                                href="{{ $order->address->maps_search() }}">
                                                <svg style="width: 15px;height: 15px">
                                                    <use
                                                        xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-location-pin') }}">
                                                    </use>
                                                </svg>
                                            </a>
                                            <span>{{ $order->address->full_address() }}</span>
                                        </td>

                                        <td class="text-center" nowrap>
                                            @can('orders_show')
                                                <button class="text-info btn btn-sm" target="popup"
                                                    onclick="popupWindow('{{ route('orders.show', $order) }}', 'test');">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-featured-playlist') }}">
                                                        </use>
                                                    </svg>
                                                </button>
                                            @endcan

                                            @can('orders_edit')
                                                <a class="text-info btn btn-sm"
                                                    href="{{ route('orders.form', [$order->customer_id, $order]) }}">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-pencil') }}">
                                                        </use>
                                                    </svg>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="9">{{ __('messages.no_orders') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="9">
                                        {{ $orders->withQueryString()->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .select2-selection__rendered {
            line-height: 23px !important;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            text-align: center;
        }

        .select2-container--default .select2-selection--multiple {
            background-color: transparent;
            border: 1px solid #d8dbe0;
            border-radius: 4px;
            cursor: text;
            padding-bottom: 10px;
            padding-right: 5px;
            position: relative;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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


        $('.select2').select2({
            placeholder: "---",
            tags: false,
            dropdownAutoWidth: true,
            // allowClear: true,
            tokenSeparators: ['/', ','],
            textAlign: 'center',
        })
    </script>
@endpush
