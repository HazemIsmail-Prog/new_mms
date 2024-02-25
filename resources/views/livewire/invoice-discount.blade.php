<div>

    <h5 class=" mt-4 text-center">{{ __('messages.discount') }}</h5>

    @if ($invoice)
        @if ($invoice->payments->count() == 0)
            <form wire:submit.prevent="save">
                <div class=" d-flex">
                    <input wire:model.lazy="discount" required autocomplete="off" type="number" id="discount" step="0.001"
                        min="0" max="{{ $invoice->services_amount }}"
                        class="form-control @error('discount') is-invalid @enderror"
                        placeholder="{{ __('messages.amount') }}">
                </div>
                <div class=" text-center">
                    <button type="submit" class=" btn btn-sm btn-facebook">{{ __('messages.save') }}</button>
                </div>
            </form>
        @endif
    @endif
</div>
