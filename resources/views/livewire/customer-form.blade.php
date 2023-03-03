<div class="card">
    <div class="card-header">@lang('messages.add_customer')</div>
    <div class="card-body">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-3">
                        <label for="name">@lang('messages.name')</label>
                        <input autofocus autocomplete="off" type="text" wire:model.lazy="name" id="name"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <span class="small text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="cid">@lang('messages.cid')</label>
                        <input autocomplete="off" type="text" wire:model.lazy="cid" id="cid"
                            class="form-control @error('cid') is-invalid @enderror">
                        @error('cid')
                            <span class="small text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="notes">@lang('messages.notes')</label>
                        <input autocomplete="off" type="text" wire:model.lazy="notes" id="notes"
                            class="form-control @error('notes') is-invalid @enderror">
                        @error('notes')
                            <span class="small text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="active">@lang('messages.status')</label>
                        <div class="form-check">
                            <input tabindex="-1" class="form-check-input" type="checkbox" wire:model.lazy="active"
                                id="active" checked>
                            <label class="form-check-label" for="active">
                                @lang('messages.active')
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <table class="mx-auto">
                    <thead>
                        <tr>
                            <th colspan="4" class="text-center">{{ __('messages.phone') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($phones as $i => $phone)
                            <tr>
                                <td class="d-none">
                                    <input autocomplete="off" type="number"
                                        wire:model.lazy="phones.{{ $i }}.id"
                                        class="form-control @error('phones.' . $i . '.id') is-invalid @enderror">
                                </td>
                                <td>
                                    <select tabindex="-1" wire:model.lazy="phones.{{ $i }}.type"
                                        class="form-control @error('phones.' . $i . '.type') is-invalid @enderror">
                                        <option value="mobile">{{ __('messages.mobile') }}</option>
                                        <option value="phone">{{ __('messages.phone') }}</option>
                                    </select>
                                </td>
                                <td>
                                    <input autocomplete="off" type="number"
                                        wire:model="phones.{{ $i }}.number"
                                        class="form-control @error('phones.' . $i . '.number') is-invalid @enderror">
                                </td>
                                <td>
                                    @if (count($phones) > 1)
                                        @if ($phones[$i]['id'] == null)
                                            <button wire:click.prevent="delete_row('phone',{{ $i }})"
                                                type="submit" class="text-danger btn btn-sm">
                                                <svg style="width: 15px;height: 15px">
                                                    <use
                                                        xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                                                    </use>
                                                </svg>
                                            </button>
                                        @else
                                            @if (\App\Models\Phone::with('orders')->find($phones[$i]['id'])->orders->count() == 0)
                                                <button wire:click.prevent="delete_row('phone',{{ $i }})"
                                                    type="submit" class="text-danger btn btn-sm">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                                                        </use>
                                                    </svg>
                                                </button>
                                            @endif
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-center">
                                <button tabindex="-1" wire:click.prevent="add_row('phone')"
                                    class="btn btn-sm btn-ghost-success">{{ __('messages.add phone') }}</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body table-responsive">

                <table class="table table-borderless table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">{{ __('messages.serial') }}</th>
                            <th class="text-center">{{ __('messages.area') }}</th>
                            <th class="text-center">{{ __('messages.block') }}</th>
                            <th class="text-center">{{ __('messages.street') }}</th>
                            <th class="text-center">{{ __('messages.jadda') }}</th>
                            <th class="text-center">{{ __('messages.building') }}</th>
                            <th class="text-center">{{ __('messages.floor') }}</th>
                            <th class="text-center">{{ __('messages.apartment') }}</th>
                            <th class="text-center">{{ __('messages.notes') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addresses as $i => $address)
                            <tr>
                                <td class="align-middle text-center">
                                    {{ $loop->iteration }}
                                    <input autocomplete="off" type="text"
                                        wire:model="addresses.{{ $i }}.id"
                                        class="d-none form-control @error('addresses.' . $i . '.id') is-invalid @enderror">
                                </td>
                                <td>
                                    <select wire:model="addresses.{{ $i }}.area_id"
                                        data-index="{{ $i }}"
                                        class=" select2 form-control @error('addresses.' . $i . '.area_id') is-invalid @enderror">
                                        <option disabled selected value="">---</option>
                                        @foreach ($areas->sortBy->name as $area)
                                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input autocomplete="off" type="text"
                                        wire:model="addresses.{{ $i }}.block"
                                        class="form-control @error('addresses.' . $i . '.block') is-invalid @enderror">
                                </td>
                                <td>
                                    <input autocomplete="off" type="text"
                                        wire:model="addresses.{{ $i }}.street"
                                        class="form-control @error('addresses.' . $i . '.street') is-invalid @enderror">
                                </td>
                                <td>
                                    <input autocomplete="off" type="text"
                                        wire:model="addresses.{{ $i }}.jadda"
                                        class="form-control @error('addresses.' . $i . '.jadda') is-invalid @enderror">
                                </td>
                                <td>
                                    <input autocomplete="off" type="text"
                                        wire:model="addresses.{{ $i }}.building"
                                        class="form-control @error('addresses.' . $i . '.building') is-invalid @enderror">
                                </td>

                                <td>
                                    <input autocomplete="off" type="text"
                                        wire:model="addresses.{{ $i }}.floor"
                                        class="form-control @error('addresses.' . $i . '.floor') is-invalid @enderror">
                                </td>

                                <td>
                                    <input autocomplete="off" type="text"
                                        wire:model="addresses.{{ $i }}.apartment"
                                        class="form-control @error('addresses.' . $i . '.apartment') is-invalid @enderror">
                                </td>

                                <td>
                                    <input autocomplete="off" type="text"
                                        wire:model="addresses.{{ $i }}.notes"
                                        class="form-control @error('addresses.' . $i . '.notes') is-invalid @enderror">
                                </td>
                                <td class="align-middle text-center">
                                    @if (count($addresses) > 1)
                                        @if ($addresses[$i]['id'] == null)
                                            <button tabindex="-1"
                                                wire:click.prevent="delete_row('address',{{ $i }})"
                                                type="submit" class="text-danger btn btn-sm">
                                                <svg style="width: 15px;height: 15px">
                                                    <use
                                                        xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                                                    </use>
                                                </svg>
                                            </button>
                                        @else
                                            @if (\App\Models\Address::with('orders')->find($addresses[$i]['id'])->orders->count() == 0)
                                                <button wire:click.prevent="delete_row('address',{{ $i }})"
                                                    type="submit" class="text-danger btn btn-sm">
                                                    <svg style="width: 15px;height: 15px">
                                                        <use
                                                            xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                                                        </use>
                                                    </svg>
                                                </button>
                                            @endif
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="10" class="text-center">
                                <button tabindex="-1" wire:click.prevent="add_row('address')"
                                    class="btn btn-sm btn-ghost-success">{{ __('messages.add address') }}</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <div class="card-footer text-center">
        <button wire:click.prevent="save_with_order(false)" class="btn btn-facebook"
            type="submit">@lang('messages.save')</button>
        <button wire:click.prevent="save_with_order(true)" class="btn btn-facebook"
            type="submit">@lang('messages.save_with_order')</button>
        <a href="{{ route('customers.index') }}" class="btn btn-ghost-danger" type="button">@lang('messages.back')</a>
    </div>
</div>


@section('styles')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .form-control {
            background: transparent;
            min-width: 150px;
        }

        .select2-container--default .select2-selection--single{
            background: transparent;
                height: 34px;
                border-color: #d8dbe0;
                border-radius: .25rem;


        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 34px;
            text-align: center;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            function initSelectAreaDrop() {
                $('.select2').select2();
                $('.select2').on('change', function(e) {
                    index = e.target.attributes['data-index'].value;
                    value = e.target.value;
                    livewire.emit('selectedCompanyItem', index, value)
                });
            }
            initSelectAreaDrop();
            window.livewire.on('select2', () => {
                initSelectAreaDrop();
            });
        });
    </script>
@endpush

@section('title')
<title>@lang('messages.customers')</title>
@endsection
