<div class="card">
    <div class="card-header">@lang('messages.add_order')</div>
    <div class="card-body">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <div class="form-group d-flex justify-content-between">
                    <h3>{{ $customer->name }}</h3>
                    @can('customers_edit')
                        <a href="{{ route('customers.form', $customer->id) }}" class="btn btn-info"
                            type="button">{{ __('messages.edit_customer') }}</a>
                    @endcan
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">{{ __('messages.phone') }}</label>
                        <select wire:model.lazy="phone_id" class="form-control @error('phone_id') is-invalid @enderror">
                            @if ($customer->phones->count() > 1)
                                <option selected value="">---</option>
                            @endif
                            @foreach ($customer->phones as $phone)
                                <option value="{{ $phone->id }}">{{ $phone->number }}</option>
                            @endforeach
                        </select>
                        @error('phone_id')
                            <span class="small text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>{{ __('messages.address') }}</label>
                        <select wire:model.lazy="address_id"
                            class="form-control @error('address_id') is-invalid @enderror">
                            @if ($customer->addresses->count() > 1)
                                <option selected value="">---</option>
                            @endif
                            @foreach ($customer->addresses as $address)
                                <option value="{{ $address->id }}">
                                    {{ $address->full_address() }}
                                </option>
                            @endforeach
                        </select>
                        @error('address_id')
                            <span class="small text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body row">
                @if ($dup_orders_count > 0)
                    <div class="col-12">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ __('messages.Duplicate Order', ['department' => \App\Models\Department::find($department_id)->name]) }}
                        </div>
                    </div>
                @endif
                <div class="form-group col-md-6">
                    <label for="department_id">@lang('messages.service_type')</label>
                    <select wire:model.lazy="department_id"
                        class="form-control text-center @error('department_id') is-invalid @enderror"
                        id="department_id">
                        @if (!$order)
                            <option value="">---</option>
                        @endif
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @if ($order && $order->technician)
                        <span
                            class="small text-danger">{{ __('messages.order assigned cannot change department') }}</span>
                    @endif
                    @error('department_id')
                        <span class="small text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @can('dispatching_menu')
                    @if (!$order)
                        @if (in_array(
                                $department_id,
                                auth()->user()->departments->pluck('id')->toArray()))
                            <div class="form-group col-md-6">
                                <label for="technician_id">@lang('messages.technician')</label>
                                <select wire:model.lazy="technician_id"
                                    class="form-control text-center @error('technician_id') is-invalid @enderror"
                                    id="technician_id">
                                    <option value="">---</option>
                                    @foreach ($technicians as $technician)
                                        <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                    @endforeach
                                </select>
                                @error('technician_id')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    @endif
                @endcan




                <div class="form-group col-md-6">
                    <label for="estimated_start_date">@lang('messages.estimated_start_date')</label>
                    <input wire:model.lazy="estimated_start_date" autocomplete="off" type="date"
                        id="estimated_start_date"
                        class="form-control text-center @error('estimated_start_date') is-invalid @enderror">
                    @error('estimated_start_date')
                        <span class="small text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="order_description">@lang('messages.order_description')</label>
                    <textarea wire:model.lazy="order_description" id="order_description"
                        class="form-control @error('order_description') is-invalid @enderror"></textarea>
                    @error('order_description')
                        <span class="small text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="notes">@lang('messages.notes')</label>
                    <textarea wire:model.lazy="orderNotes" id="notes" class="form-control @error('orderNotes') is-invalid @enderror"></textarea>
                    @error('orderNotes')
                        <span class="small text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer text-center">
        <button wire:loading.attr="disabled" wire:click="saveOrder" class="btn btn-facebook"
            type="button">@lang('messages.save')</button>
        @if (!$order)
            {{-- create --}}
            <a href="{{ route('customers.index') }}" class="btn btn-ghost-danger" type="button">@lang('messages.back')</a>
        @else
            {{-- edit --}}
            <a href="{{ route('orders.index') }}" class="btn btn-ghost-danger" type="button">@lang('messages.back')</a>
        @endif
    </div>
</div>

@section('title')
    <title>@lang('messages.orders')</title>
@endsection
