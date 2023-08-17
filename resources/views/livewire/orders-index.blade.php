@section('title')
    <title>@lang('messages.orders')</title>
@endsection


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

                {{-- filters --}}
                <div x-data="{ search_form: false }">
                    <button @click="search_form = ! search_form" class="btn btn-sm btn-facebook mb-2">
                        <svg style="width: 15px;height: 15px">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-search') }}"></use>
                        </svg>
                    </button>
                    <div x-show="search_form" x-collapse.duration.100ms style="display: none">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex flex-wrap flex-xxl-nowrap">
                                    <div class="form-group w-100">
                                        <label for="name">{{ __('messages.customer_name') }}</label>
                                        <input wire:ignore wire:model="filter.customer_name" type="text"
                                            id="name" class="form-control">
                                    </div>
                                    <div class="form-group w-100">
                                        <label for="phone">{{ __('messages.customer_phone') }}</label>
                                        <input wire:ignore wire:model.debounce.1000ms="filter.customer_phone" type="number"
                                            id="phone" class="form-control">
                                    </div>
                                    <div wire:ignore class="form-group w-100">
                                        <label for="area_id">{{ __('messages.area') }}</label>
                                        <select data-model="areas" class="form-control select2" multiple
                                            style="width: 100%" id="area_id">
                                            <option disabled value="">---</option>
                                            @foreach ($areas->sortBy->name as $area)
                                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group w-100">
                                        <label for="block">{{ __('messages.block') }}</label>
                                        <input wire:ignore wire:model="filter.block" type="text" id="block"
                                            class="form-control">
                                    </div>
                                    <div class="form-group w-100">
                                        <label for="street">{{ __('messages.street') }}</label>
                                        <input wire:ignore wire:model="filter.street" type="text" id="street"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap flex-xxl-nowrap">

                                    <div class="form-group w-100">
                                        <label for="order_number">{{ __('messages.order_number') }}</label>
                                        <input wire:model="filter.order_number" autocomplete="off"
                                            list="autocompleteOff" type="number" name="order_number" id="order_number"
                                            class="form-control" value="{{ request('order_number') }}">
                                    </div>
                                    <div wire:ignore class="form-group w-100">
                                        <label for="creator_id">{{ __('messages.creator') }}</label>
                                        <select data-model="creators" class="form-control select2" multiple
                                            style="width: 100%" id="creator_id">
                                            <option disabled value="">---</option>
                                            @foreach ($creators as $creator)
                                                <option value="{{ $creator->id }}">{{ $creator->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div wire:ignore class="form-group w-100">
                                        <label for="status_id">{{ __('messages.status') }}</label>
                                        <select data-model="statuses" class="form-control select2" multiple="multiple"
                                            id="status_id" style="width: 100%">
                                            <option disabled value="">---</option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div wire:ignore class="form-group w-100">
                                        <label for="technician_id">{{ __('messages.technician') }}</label>
                                        <select data-model="technicians" class="form-control select2"
                                            style="width: 100%" multiple id="technician_id">
                                            <option disabled value="">---</option>
                                            @foreach ($technicians as $technician)
                                                <option
                                                    {{ $filter['technicians'] ? (in_array($technician->id, $filter['technicians']) ? 'selected' : '') : '' }}
                                                    value="{{ $technician->id }}">{{ $technician->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div wire:ignore class="form-group w-100">
                                        <label for="department_id">{{ __('messages.department') }}</label>
                                        <select data-model="departments" class="form-control select2" multiple
                                            style="width: 100%" id="department_id">
                                            <option disabled value="">---</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group w-100">
                                        <label for="start_created_at">{{ __('messages.created_at') }}</label>
                                        <input wire:ignore wire:model="filter.start_created_at" type="date"
                                            id="start_created_at" class="form-control">
                                        <input wire:ignore wire:model="filter.end_created_at" type="date"
                                            id="end_created_at" class="form-control">
                                    </div>

                                    <div class="form-group w-100">
                                        <label for="start_completed_at">{{ __('messages.completed_at') }}</label>
                                        <input wire:ignore wire:model="filter.start_completed_at" type="date"
                                            id="start_completed_at" class="form-control">
                                        <input wire:ignore wire:model="filter.end_completed_at" type="date"
                                            id="end_completed_at" class="form-control">
                                    </div>


                                </div>

                                <button wire:click="export"
                                    class="btn btn-sm btn-facebook">{{ __('messages.export_to_excel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- filters --}}

                <div wire:poll.30s class="table-responsive">

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
                                <th class="text-center">@lang('messages.remaining_amount')</th>
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
                                            <div class="small">{{ date('H:i', strtotime($order->completed_at)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td nowrap>
                                        <div>{{ @$order->customer->name }}</div>
                                        <div>{{ $order->phone->number }}</div>
                                        <div>{{ @$order->customer->notes }}</div>
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

                                    <td>
                                        {{ $order->invoices->sum('remaining_amount') == 0 ? '' : number_format($order->invoices->sum('remaining_amount'), 3) }}
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
                                    <td class="text-center" colspan="10">{{ __('messages.no_orders') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class=" d-flex justify-content-between align-items-center mt-2">
                    <div>{{ $orders->links() }}</div>
                    <select class=" form-control" style="width: fit-content;" wire:model="pagination">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="500">500</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>


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

        $(document).ready(function() {

            $('.select2').select2({
                placeholder: "---",
                tags: false,
                dropdownAutoWidth: true,
                // allowClear: true,
                tokenSeparators: ['/', ','],
                textAlign: 'center',
            })

            $('.select2').on('change', function(e) {
                console.log(e.target.attributes['data-model'].value)
                @this.set('filter.' + e.target.attributes['data-model'].value, $(this).val());
                // index = e.target.attributes['data-index'].value;
                // value = e.target.value;
                // livewire.emit('selectedCompanyItem', index, value)
            });
        })
    </script>
@endpush
