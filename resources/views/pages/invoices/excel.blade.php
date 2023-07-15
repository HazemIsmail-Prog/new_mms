{{-- <table>
    <thead>
        <tr>
            <th>@lang('messages.order_number') </th>
            <th>@lang('messages.customer_name') </th>
            <th>@lang('messages.customer_phone') </th>
            <th>@lang('messages.address') </th>
            <th>@lang('messages.creator') </th>
            <th>@lang('messages.technician') </th>
            <th>@lang('messages.status') </th>
            <th>@lang('messages.department') </th>
            <th>@lang('messages.estimated_start_date')</th>
            <th>@lang('messages.notes') </th>
            <th>@lang('messages.order_description') </th>
            <th>@lang('messages.completed_at') </th>
            <th>@lang('messages.cancelled_at') </th>
            <th>@lang('messages.created_at') </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row->id }} </td>
                <td>{{ $row->customer->name }} </td>
                <td>{{ $row->phone->number }} </td>
                <td>{{ $row->address->full_address() }} </td>
                <td>{{ $row->creator->name }} </td>
                <td>{{ @$row->technician->name }} </td>
                <td>{{ $row->status->name }} </td>
                <td>{{ $row->department->name }} </td>
                <td>{{ $row->estimated_start_date->format('d-m-Y') }} </td>
                <td>{{ $row->notes }} </td>
                <td>{{ $row->order_description }} </td>
                <td>{{ $row->completed_at ? $row->completed_at->format('d-m-Y H:i') : '' }}</td>
                <td>{{ $row->cancelled_at ? $row->cancelled_at->format('d-m-Y H:i') : '' }}</td>
                <td>{{ $row->created_at->format('d-m-Y H:i') }} </td>
            </tr>
        @endforeach
    </tbody>
</table> --}}




<table>
    <thead>
        <tr>
            <th>{{ __('messages.invoice_number') }}</th>
            <th>{{ __('messages.order_number') }}</th>
            <th>{{ __('messages.date') }}</th>
            <th>{{ __('messages.department') }}</th>
            <th>{{ __('messages.technician') }}</th>
            <th>{{ __('messages.customer_name') }}</th>
            <th>{{ __('messages.customer_phone') }}</th>
            <th>{{ __('messages.amount') }}</th>
            <th>{{ __('messages.services') }}</th>
            <th>{{ __('messages.parts') }}</th>
            <th>{{ __('messages.cash') }}</th>
            <th>{{ __('messages.knet') }}</th>
            <th>{{ __('messages.paid_amount') }}</th>
            <th>{{ __('messages.remaining_amount') }}</th>
            <th>{{ __('messages.payment_status') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->order_id }}</td>
                <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                <td>{{ $invoice->order->department->name }}</td>
                <td>{{ $invoice->order->technician->name }}</td>
                <td>{{ $invoice->order->customer->name }}</td>
                <td>{{ $invoice->order->phone->number }}</td>
                <td>{{ $invoice->amount == 0 ? '' : $invoice->amount }}</td>
                <td>{{ $invoice->services_amount == 0 ? '' : $invoice->services_amount }}</td>
                <td>{{ $invoice->parts_amount == 0 ? '' : $invoice->parts_amount }}</td>
                <td>{{ $invoice->payments->where('method', 'cash')->sum('amount') == 0 ? '' : $invoice->payments->where('method', 'cash')->sum('amount') }}</td>
                <td>{{ $invoice->payments->where('method', 'knet')->sum('amount') == 0 ? '' : $invoice->payments->where('method', 'knet')->sum('amount') }}</td>
                <td>{{ $invoice->payments->sum('amount') == 0 ? '' : $invoice->payments->sum('amount') }}</td>
                <td>{{ $invoice->remaining_amount == 0 ? '' : $invoice->remaining_amount }}</td>
                <td class=" text-center">{{ __('messages.' . $invoice->payment_status) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
