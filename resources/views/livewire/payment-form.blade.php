<div>
    <form wire:submit.prevent="save_payment">
        <div class=" d-flex">
            <input wire:model.lazy="amount" required autocomplete="off" type="number" id="amount" step="0.001"
                min="0" max="{{ $invoice->remaining_amount }}"
                class="form-control @error('amount') is-invalid @enderror" placeholder="{{ __('messages.amount') }}">

            <select required wire:model="method" class=" form-control @error('method') is-invalid @enderror">
                <option value="" selected disabled>{{ __('messages.payment_method') }}</option>
                <option value="cash">{{ __('messages.cash') }}</option>
                <option value="knet">{{ __('messages.knet') }}</option>
            </select>
        </div>
        <div class=" text-center">
            <button type="submit" class=" btn btn-sm btn-facebook">{{ __('messages.save') }}</button>
            <button type="button" wire:click="close_payment_form"
                class=" btn btn-sm text-danger">{{ __('messages.cancel') }}</button>
        </div>
    </form>
</div>
