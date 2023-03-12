<div>

    <h5 class=" mt-4 text-center">{{ __('messages.payments') }}</h5>

    @forelse ($invoice->payments as $payment)
        <div class="card">
            <div class="card-body p-0 m-0 d-flex ">
                <div class="p-3 bg-success text-center text-white w-25">
                    <div>{{ number_format($payment->amount,3) }}</div>
                    <div>{{ __('messages.' . $payment->method) }}</div>
                </div>
                <div class="align-self-center flex-fill">
                    <div>{{ $payment->user->name }}</div>
                    <div>{{ $payment->created_at->format('d-m-Y') }}</div>
                    <div>{{ $payment->created_at->format('H:i') }}</div>
                </div>
                <div class="align-self-center p-3">
                    <form class="w-100 m-0" wire:submit.prevent="delete_payment({{ $payment->id }})">
                        <button type="submit" class=" m-0 btn btn-sm btn-block btn-outline-danger"
                            onclick="return confirm('{{ __('messages.delete_payment_confirmation') }}')">
                            <svg style="width: 15px;height: 15px">
                                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                                </use>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        @if (!$show_payment_form)
            <div class=" text-center my-3">{{ __('messages.no_payments_found') }}</div>
        @endif
    @endforelse

    @if ($invoice->remaining_amount > 0 && !$show_payment_form)
        <div class=" text-center">
            <button wire:click="$set('show_payment_form','true')"
                class=" m-0 btn btn-sm btn-outline-success">{{ __('messages.create_payment') }}</button>
        </div>
    @endif

    @if ($show_payment_form)
        @livewire('payment-form', ['invoice_id' => $invoice->id], key('payment-form-' . $invoice->id))
    @endif
</div>
