<div>

    <form wire:submit.prevent="create_invoice">
        <table class=" table table-striped border">
            <thead>
                <tr>
                    <th class=" align-middle" colspan="2">{{ __('messages.service') }}</th>
                    <th class=" align-middle text-center" width="15%">
                        {{ __('messages.quantity') }}</th>
                    <th class=" align-middle text-center" width="15%">
                        {{ __('messages.unit_price') }}</th>
                    <th class=" align-middle text-center" width="15%">
                        {{ __('messages.service_total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services->sortBy('name') as $index => $service)
                    <tr style="min-height: 45px; height:45px;">
                        <td width="1%" class=" align-middle">
                            <input wire:model="selected_services.{{ $index }}.service_id"
                                class=" form-check-inline" type="checkbox" value="{{ $service->id }}"
                                id="Check{{ $service->id }}">
                        </td>
                        <td class=" align-middle">
                            <label class="form-check-label" for="Check{{ $service->id }}">{{ $service->name }}</label>
                            <div>
                                <span
                                    class=" badge bg-danger text-white px-2 badge-pill pb-0">{{ $service->min_price }}</span>
                                <span
                                    class=" badge bg-success text-white px-2 badge-pill pb-0">{{ $service->max_price }}</span>
                            </div>
                        </td>
                        <td class=" align-middle">
                            @if (@$selected_services[$index]['service_id'])
                                <input required wire:model="selected_services.{{ $index }}.quantity"
                                    type="number" placeholder="{{ __('messages.quantity') }}" min="0"
                                    step="0.01"
                                    class=" form-control form-control-sm @error('selected_services.' . $index . '.quantity') is-invalid @enderror">
                            @endif
                        </td>
                        <td class=" align-middle">
                            @if (@$selected_services[$index]['service_id'])
                                <input required wire:model="selected_services.{{ $index }}.price" type="number"
                                    min="{{ $service->min_price }}" max="{{ $service->max_price }}" step="0.001"
                                    placeholder="{{ __('messages.unit_price') }}"
                                    class=" form-control form-control-sm @error('selected_services.' . $index . '.price') is-invalid @enderror">
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            {{ @$selected_services[$index]['service_total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class=" text-center">
                        <button type="submit" class=" btn btn-sm btn-facebook">{{ __('messages.save') }}</button>
                        <button type="button" wire:click="close_invoice_form" class=" btn btn-sm text-danger">{{ __('messages.cancel') }}</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>

</div>

