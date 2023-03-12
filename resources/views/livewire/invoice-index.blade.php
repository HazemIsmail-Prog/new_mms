<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>@lang('messages.invoices')</div>
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
                            <thead>
                                <tr>
                                    <th>{{ __('messages.invoice_number') }}</th>
                                    <th>{{ __('messages.order_number') }}</th>
                                    <th>{{ __('messages.customer_name') }}</th>
                                    <th class=" text-center">{{ __('messages.customer_phone') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
                                    <th>{{ __('messages.paid_amount') }}</th>
                                    <th>{{ __('messages.remaining_amount') }}</th>
                                    <th class=" text-center">{{ __('messages.payment_status') }}</th>
                                    <th></th>
                                </tr>
                                <tr class="bg-light">
                                    <td><input autocomplete="off" list="autocompleteOff" type="number"
                                            wire:model="search.invoice_number" class="form-control form-control-sm"
                                            value="{{ request('invoice_number') }}">
                                    </td>
                                    <td><input autocomplete="off" list="autocompleteOff" type="number"
                                            wire:model="search.order_number" class="form-control form-control-sm"
                                            value="{{ request('order_number') }}">
                                    </td>
                                    <td><input autocomplete="off" list="autocompleteOff" type="text"
                                            wire:model="search.customer_name" class="form-control form-control-sm"
                                            value="{{ request('customer_name') }}">
                                    </td>
                                    <td><input autocomplete="off" list="autocompleteOff" type="number"
                                            wire:model="search.phone" class="form-control form-control-sm"
                                            value="{{ request('phone') }}"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <select wire:model="search.payment_status"
                                            class=" form-control form-control-sm">
                                            <option value="">{{ __('messages.all') }}</option>
                                            <option value="pending">{{ __('messages.pending') }}</option>
                                            <option value="partially_paid">{{ __('messages.partially_paid') }}</option>
                                            <option value="paid">{{ __('messages.paid') }}</option>
                                        </select>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->id }}</td>
                                        <td>
                                            <button class="btn btn-sm" target="popup"
                                                onclick="popupWindow('{{ route('orders.show', $invoice->order_id) }}', 'test');">
                                                {{ $invoice->order_id }}
                                            </button>
                                        </td>
                                        <td>{{ $invoice->order->customer->name }}</td>
                                        <td class=" text-center">{{ $invoice->order->phone->number }}</td>
                                        <td>{{ number_format($invoice->amount,3) }}</td>
                                        <td>{{ number_format($invoice->payments->sum('amount'),3) }}</td>
                                        <td>{{ $invoice->remaining_amount == 0 ? '-' : number_format($invoice->remaining_amount,3) }}</td>
                                        <td class=" text-center">{{ __('messages.'.$invoice->payment_status) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class=" text-center" colspan="8">{{ __('messages.no_records_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        {{ $invoices->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('title')
    <title>@lang('messages.invoices')</title>
@endsection


@push('scripts')
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
    </script>
@endpush
