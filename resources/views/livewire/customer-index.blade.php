<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>{{ __('messages.customers') }}</div>
                    <div>{{ __('messages.results_number') }} = {{ $customers->total() }}</div>
                    @can('customers_create')
                        <div><a class="btn btn-info" href="{{ route('customers.form') }}">@lang('messages.add_customer')</a></div>
                    @endcan
                </div>

                <div class="card-body">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                    @endif

                    <div class="table-responsive">

                        <table class="table table-hover table-outline mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>@lang('messages.name')</th>
                                    <th class="text-center">{{ __('messages.tel') }}</th>
                                    <th class="text-center">{{ __('messages.address') }}</th>
                                    <th class="text-center">{{ __('messages.orders') }}</th>
                                    <th class="text-center">{{ __('messages.remaining_amount') }}</th>
                                    <th class="text-center">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-light">
                                    <td><input wire:ignore autocomplete="off" list="autocompleteOff" type="text"
                                            wire:model="search.name" class="form-control"
                                            value="{{ request('name') }}"></td>
                                    <td><input wire:ignore autocomplete="off" list="autocompleteOff" type="number"
                                            wire:model.debounce.1000ms="search.phone" class="form-control"
                                            value="{{ request('phone') }}"></td>
                                    <td class="custom-control-inline">
                                        <select class="form-control" wire:model="search.area_id" id="area_id">
                                            <option selected value="">{{ __('messages.all_areas') }}
                                            </option>
                                            @foreach ($areas->sortBy->name as $area)
                                                <option {{ request('area_id') == $area->id ? 'selected' : '' }}
                                                    value="{{ $area->id }}">{{ $area->name }}</option>
                                            @endforeach
                                        </select>
                                        <input wire:ignore autocomplete="off" list="autocompleteOff" type="text"
                                            wire:model="search.block" class="form-control mx-1"
                                            value="{{ request('block') }}" placeholder="{{ __('messages.block') }}">
                                        <input wire:ignore autocomplete="off" list="autocompleteOff" type="text"
                                            wire:model="search.street" class="form-control"
                                            value="{{ request('street') }}" placeholder="{{ __('messages.street') }}">
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                @forelse($customers as $customer)
                                    <tr>
                                        <td nowrap>
                                            <div>{{ $customer->name }}</div>
                                            <div>{{ @$customer->notes }}</div>
                                        </td>
                                        <td class="text-center">
                                            @foreach ($customer->phones as $phone)
                                                <div>{{ $phone->number }}</div>
                                            @endforeach
                                        </td>
                                        <td nowrap>
                                            @foreach ($customer->addresses as $address)
                                                <div>
                                                    <a class="text-dark btn btn-sm" target="_blank"
                                                        href="{{ $address->maps_search() }}">
                                                        <svg style="width: 15px;height: 15px">
                                                            <use
                                                                xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-location-pin') }}">
                                                            </use>
                                                        </svg>
                                                    </a>
                                                    <span>{{ $address->full_address() }}</span>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @if ($customer->orders_count > 0)
                                                @can('orders_menu')
                                                    <a href="{{ route('orders.index', ['customer_id' => $customer->id]) }}"
                                                        class="btn btn-warning btn-sm text-white font-weight-bolder">
                                                        {{ $customer->orders_count }}
                                                    </a>
                                                @endcan
                                            @endif
                                        </td>
                                        <td>{{ $customer->balance == 0 ? '-' : number_format($customer->balance, 3) }}
                                        </td>
                                        <td class="text-center" nowrap>
                                            @can('orders_create')
                                                <a class="text-success btn btn-sm"
                                                    href="{{ route('orders.form', $customer->id) }}">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-plus') }}">
                                                        </use>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('customers_edit')
                                                <a class="text-info btn btn-sm"
                                                    href="{{ route('customers.form', $customer->id) }}">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-pencil') }}">
                                                        </use>
                                                    </svg>
                                                </a>
                                            @endcan
                                            {{-- @can('customers_delete')
                                                <form class="d-inline" action=""
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger btn btn-sm"
                                                        onclick="return confirm('{{ __('messages.delete_r_u_sure') }}')">
                                                        <svg style="width: 15px;height: 15px">
                                                            <use
                                                                xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                                                            </use>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endcan --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="6">
                                            <div>
                                                {{ __('messages.no_customers_found') }}
                                            </div>
                                            @can('customers_create')
                                                <div><a class="btn btn-info"
                                                        href="{{ route('customers.form') }}">@lang('messages.add_customer')</a></div>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class=" d-flex justify-content-between align-items-center mt-2">
                        <div>{{ $customers->links() }}</div>
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
</div>

@section('title')
    <title>@lang('messages.customers')</title>
@endsection
