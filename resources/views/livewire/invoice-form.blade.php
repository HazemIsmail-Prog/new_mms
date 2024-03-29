<div>

    <input wire:model="search" type="text" class=" form-control mb-4" placeholder="{{ __('messages.search') }}">

    <form wire:submit.prevent="form_submit" method="POST" action="">
        <div class=" d-flex justify-content-between">
            <div>
                <h1>{{ __('messages.services') }}</h1>
                <div style="max-height: 400px;overflow-y:auto">
                    <table class=" table table-striped border">
                        <tbody>
                            @foreach ($services->where('type', 'service')->sortBy('name') as $service)
                                <tr style="min-height: 45px; height:45px;">
                                    <td width="1%" class=" align-middle">
                                        <input wire:model="selected_services.{{ $service->id }}.service_id"
                                            class=" form-check-inline" type="checkbox" value="{{ $service->id }}"
                                            id="Check{{ $service->id }}">
                                    </td>
                                    <td class=" align-middle">
                                        <label class="form-check-label"
                                            for="Check{{ $service->id }}">{{ $service->name }}</label>
                                        <div>
                                            <span
                                                class=" badge bg-danger text-white px-2 badge-pill pb-0">{{ $service->min_price }}</span>
                                            <span
                                                class=" badge bg-success text-white px-2 badge-pill pb-0">{{ $service->max_price }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <h1>{{ __('messages.parts') }}</h1>
                <div style="max-height: 400px;overflow-y:auto">
                    <table class=" table table-striped border">
                        <tbody>
                            @foreach ($services->where('type', 'part')->sortBy('name') as $service)
                                <tr style="min-height: 45px; height:45px;">
                                    <td width="1%" class=" align-middle">
                                        <input wire:model="selected_services.{{ $service->id }}.service_id"
                                            class=" form-check-inline" type="checkbox" value="{{ $service->id }}"
                                            id="Check{{ $service->id }}">
                                    </td>
                                    <td class=" align-middle">
                                        <label class="form-check-label"
                                            for="Check{{ $service->id }}">{{ $service->name }}</label>
                                        <div>
                                            <span
                                                class=" badge bg-danger text-white px-2 badge-pill pb-0">{{ $service->min_price }}</span>
                                            <span
                                                class=" badge bg-success text-white px-2 badge-pill pb-0">{{ $service->max_price }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        @if ($selected_services)
            <h1 class="mt-4">{{ __('messages.invoice') }}</h1>
            <table class="table table-striped border">
                <thead>
                    <tr>
                        <th class=" align-middle">{{ __('messages.service') }}/{{ __('messages.part') }}</th>
                        <th class=" align-middle text-center" width="15%">
                            {{ __('messages.quantity') }}</th>
                        <th class=" align-middle text-center" width="15%">
                            {{ __('messages.unit_price') }}</th>
                        <th class=" align-middle text-center" width="15%">
                            {{ __('messages.service_total') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($selected_services as $index => $service)
                        <tr>
                            <td>
                                <label class="form-check-label">{{ $service['name'] }}</label>
                                <div>
                                    <span
                                        class=" badge bg-danger text-white px-2 badge-pill pb-0">{{ $service['min_price'] }}</span>
                                    <span
                                        class=" badge bg-success text-white px-2 badge-pill pb-0">{{ $service['max_price'] }}</span>
                                </div>
                            </td>
                            <td>
                                <input required wire:model="selected_services.{{ $index }}.quantity"
                                    type="number" placeholder="{{ __('messages.quantity') }}" min="0"
                                    step="0.01"
                                    class=" form-control form-control-sm @error('selected_services.' . $index . '.quantity') is-invalid @enderror">
                            </td>
                            <td>
                                <input required wire:model="selected_services.{{ $index }}.price" type="number"
                                    min="{{ $service['min_price'] }}" max="{{ $service['max_price'] }}" step="0.001"
                                    placeholder="{{ __('messages.unit_price') }}"
                                    class=" form-control form-control-sm @error('selected_services.' . $index . '.price') is-invalid @enderror">
                            </td>
                            <td>{{ $service['service_total'] }}</td>
                            <td>
                                <svg class=" text-danger" wire:click="unset({{ $index }})"
                                    style="width: 15px;height: 15px">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                                    </use>
                                </svg>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="1">{{ __('messages.total') }}</th>
                        <th colspan="4">
                            {{ number_format(collect($selected_services)->sum('service_total'), 3) }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        @endif
        <div class=" text-center mt-4">
            {{-- Warning --}}
            @if ($showWarning)
                <div class="alert alert-warning alert-dismissible fade show text-center p-4" role="alert">
                    @if ($services_count == 0)
                        <h2>{{ __('messages.no_services_selected') }}</h2>
                        <h4 class="mb-4">{{ __('messages.are_u_sure') }}</h4>
                    @endif
                    @if ($parts_count == 0)
                        <h2>{{ __('messages.no_parts_selected') }}</h2>
                        <h4 class="mb-4">{{ __('messages.are_u_sure') }}</h4>
                    @endif
                    <div>
                        <button wire:click="confirm_save" type="button"
                            class=" btn btn-warning">{{ __('messages.confirm_saving') }}</button>
                        <button type="button" wire:click="$set('showWarning',false)"
                            class=" btn text-danger">{{ __('messages.back_to_invoice') }}</button>
                    </div>
                </div>
            @endif
            {{-- Warning --}}
            @error('selected_services')
                <h2 class=" text-danger mb-4">{{ __('messages.selected_services_required') }}</h2>
            @enderror
            @error('search')
                <h2 class=" text-danger mb-4">{{ __('messages.clear_search_to_continue') }}</h2>
            @enderror
            @if (!$showWarning)
                <button type="submit" class=" btn btn-facebook">{{ __('messages.save') }}</button>
                <button type="button" wire:click="close_invoice_form"
                    class=" btn text-danger">{{ __('messages.cancel') }}</button>
            @endif
        </div>
    </form>

</div>
