<div>
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between">
            <div>{{ __('messages.invoices') }}</div>
        </div>
        <div class="card-body">
            @if ($invoices->count() > 0)
                @foreach ($invoices as $invoice)
                    <div class="card">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center"
                            style="color:black">
                            <div>{{ __('messages.invoice_number') }} : {{ $invoice->id }}</div>
                            @if ($invoice->payments->count() == 0  && auth()->id() == 1)
                                <div>
                                    <form method="POST" class="w-100 m-0"
                                        wire:submit.prevent="delete_invoice({{ $invoice->id }})">
                                        <button type="submit" class=" m-0 btn btn-sm btn-outline-danger"
                                            onclick="return confirm('{{ __('messages.delete_invoice_confirmation') }}')">
                                            <svg style="width: 15px;height: 15px">
                                                <use
                                                    xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                                                </use>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <table class=" table table-borderless m-0 font-sm">
                                <tbody>
                                    <tr class=" border-bottom">
                                        <th></th>
                                        <th class=" text-center">{{ __('messages.quantity') }}</th>
                                        <th style="text-align: right;">{{ __('messages.unit_price') }}</th>
                                        <th style="text-align: right;">{{ __('messages.total') }}</th>
                                    </tr>
                                    @if ($invoice->invoice_details->where('service.type', 'service')->count() > 0)
                                        <tr class=" border-bottom">
                                            <th>{{ __('messages.services') }}</th>
                                        </tr>
                                        @foreach ($invoice->invoice_details->where('service.type', 'service') as $row)
                                            <tr>
                                                <td class=" font-xs">{{ $row->service->name }}</td>
                                                <td class=" text-center font-xs">{{ $row->quantity }}</td>
                                                <td class=" font-xs" style="text-align: right;">
                                                    {{ number_format($row->price, 3) }}</td>
                                                <td class="font-xs" style="text-align: right;">
                                                    {{ number_format($row->total, 3) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if ($invoice->invoice_details->where('service.type', 'part')->count() > 0)
                                        <tr class=" border-bottom">
                                            <th>{{ __('messages.parts') }}</th>
                                        </tr>
                                        @foreach ($invoice->invoice_details->where('service.type', 'part') as $row)
                                            <tr>
                                                <td class=" font-xs">{{ $row->service->name }}</td>
                                                <td class=" text-center font-xs">{{ $row->quantity }}</td>
                                                <td class=" font-xs" style="text-align: right;">
                                                    {{ number_format($row->price, 3) }}</td>
                                                <td class="font-xs" style="text-align: right;">
                                                    {{ number_format($row->total, 3) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    <tr class=" border-top">
                                        <th>{{ __('messages.total') }}</th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align: right;">{{ number_format($invoice->amount, 3) }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>{{ __('messages.paid_amount') }}</th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align: right;">
                                            {{ number_format($invoice->payments->sum('amount'), 3) }}</th>
                                    </tr>
                                    <tr>
                                        <th>{{ __('messages.remaining_amount') }}</th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align: right;">
                                            {{ number_format($invoice->remaining_amount, 3) }}</th>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            @livewire('invoice-payments', ['invoice_id' => $invoice->id], key('invoice-payments-' . $invoice->id))
                        </div>
                    </div>
                @endforeach
            @else
                @if (!$show_invoice_form)
                    <div class=" text-center mb-3">{{ __('messages.no_invoices_found') }}</div>
                @endif
            @endif


            @if (!$show_invoice_form)
                <div class=" text-center">
                    <button wire:click="show_invoice_form"
                        class=" btn btn-sm btn-facebook">{{ __('messages.create_invoice') }}</button>
                </div>
            @endif


            @if ($show_invoice_form)
                @livewire('invoice-form', ['order_id' => $order->id], key('invoice-form-' . $order->id))
            @endif

        </div>
    </div>
</div>
