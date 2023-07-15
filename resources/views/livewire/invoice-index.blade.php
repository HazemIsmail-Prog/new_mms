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

                    <button wire:click="export"
                        class="btn btn-sm btn-facebook mb-2">{{ __('messages.export_to_excel') }}</button>


                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-outline mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.invoice_number') }}</th>
                                    <th>{{ __('messages.order_number') }}</th>
                                    <th>{{ __('messages.date') }}</th>
                                    <th>{{ __('messages.department') }}</th>
                                    <th>{{ __('messages.technician') }}</th>
                                    <th>{{ __('messages.customer_name') }}</th>
                                    <th class=" text-center">{{ __('messages.customer_phone') }}</th>
                                    <th>{{ __('messages.amount') }}</th>
                                    <th>{{ __('messages.services') }}</th>
                                    <th>{{ __('messages.parts') }}</th>
                                    <th>{{ __('messages.cash') }}</th>
                                    <th>{{ __('messages.knet') }}</th>
                                    <th>{{ __('messages.paid_amount') }}</th>
                                    <th>{{ __('messages.remaining_amount') }}</th>
                                    <th class=" text-center">{{ __('messages.payment_status') }}</th>
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
                                    <td><input autocomplete="off" list="autocompleteOff" type="date"
                                            wire:model="search.invoice_date" class="form-control form-control-sm"
                                            value="{{ request('invoice_date') }}"></td>
                                    <td>
                                        <select wire:model="search.department_id" class="form-control form-control-sm">
                                            <option value="">---</option>
                                            @foreach ($departments->sortBy('name') as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select wire:model="search.technician_id" class="form-control form-control-sm">
                                            <option value="">---</option>
                                            @foreach ($technicians->sortBy('name') as $technician)
                                                <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                            @endforeach
                                        </select>
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
                                    <td></td>
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
                                        <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <div wire:click="$set('search.department_id', '{{ $invoice->order->department_id }}')"
                                                style="cursor: pointer">
                                                {{ $invoice->order->department->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div wire:click="$set('search.technician_id', '{{ $invoice->order->technician_id }}')"
                                                style="cursor: pointer">
                                                {{ $invoice->order->technician->name }}
                                            </div>
                                            
                                        </td>
                                        <td>{{ $invoice->order->customer->name }}</td>
                                        <td class=" text-center">{{ $invoice->order->phone->number }}</td>
                                        <td>{{ $invoice->amount == 0 ? '' : number_format($invoice->amount, 3) }}</td>
                                        <td>{{ $invoice->services_amount == 0 ? '' : number_format($invoice->services_amount, 3) }}
                                        </td>
                                        <td>{{ $invoice->parts_amount == 0 ? '' : number_format($invoice->parts_amount, 3) }}
                                        </td>
                                        <td>{{ $invoice->cash_amount == 0 ? '' : number_format($invoice->cash_amount, 3) }}
                                        </td>
                                        <td>{{ $invoice->knet_amount == 0 ? '' : number_format($invoice->knet_amount, 3) }}
                                        </td>
                                        <td>{{ $invoice->total_paid_amount == 0 ? '' : number_format($invoice->total_paid_amount, 3) }}
                                        </td>
                                        <td>{{ $invoice->remaining_amount == 0 ? '' : number_format($invoice->remaining_amount, 3) }}
                                        </td>
                                        <td class=" text-center">{{ __('messages.' . $invoice->payment_status) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class=" text-center" colspan="15">{{ __('messages.no_records_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="bg-light text-black-50">
                                    <th colspan="7" class=" text-center">{{ __('messages.total') }}</th>
                                    <th>{{ number_format($invoices->sum('amount'), 3) }}</th>
                                    <th>{{ number_format($invoices->sum('services_amount'), 3) }}</th>
                                    <th>{{ number_format($invoices->sum('parts_amount'), 3) }}</th>
                                    <th>{{ number_format($invoices->sum('cash_amount'), 3) }}</th>
                                    <th>{{ number_format($invoices->sum('knet_amount'), 3) }}</th>
                                    <th>{{ number_format($invoices->sum('total_paid_amount'), 3) }}</th>
                                    <th>{{ number_format($invoices->sum('remaining_amount'), 3) }}</th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>


                        </table>
                        <div class=" d-flex justify-content-between align-items-center mt-2">
                            <div>{{ $invoices->links() }}</div>
                            <select wire:model="pagination">
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
