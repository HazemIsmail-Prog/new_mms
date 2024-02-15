<!DOCTYPE html>
<html lang="ar" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;800&display=swap" rel="stylesheet">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        html,
        body {
            font-family: 'Cairo', sans-serif;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            font-size: 0.8rem;
            margin-top: 1.2rem;
        }

        .table th {
            background-color: #ddd;
        }

        .table th,
        .table td {
            border: 1px solid rgb(190, 190, 190);
            padding: 5px 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-start {
            text-align: {{ config('app.locale') == 'ar' ? 'right' : 'left' }};
        }

        .text-end {
            text-align: {{ config('app.locale') == 'ar' ? 'left' : 'right' }};
        }

        .logo {
            width: 110px;
            height: 100px;
        }
    </style>
    <title>{{ $page_title }}</title>
</head>

<body>

    <table class="table">
        <tr>
            <td style="border: none;vertical-align: text-top" width="50%">
                <img class="logo" src="{{ asset('storage/images/logo.jpg') }}" alt="logo">

            </td>
            <td width="50%" class="text-end" style="border: none;vertical-align: text-top">
                {{ __('messages.customer_invoice') }}
            </td>
        </tr>
    </table>




    {{-- Customer Info --}}

    <table class="table" style="border: 1px solid rgb(190, 190, 190);">
        <tr>
            <td style="border: none" rowspan="3">{{ __('messages.customer_info') }}</td>
            <td style="border: none">{{ $invoice->order->customer->name }}</td>
        </tr>
        <tr>
            <td style="border: none">{{ $invoice->order->phone->number }}</td>
        </tr>
        <tr>
            <td style="border: none">{{ $invoice->order->address->full_address() }}</td>
        </tr>
    </table>


    {{-- Invoice Info --}}
    <table class="table">
        <tr>
            <td>{{ __('messages.invoice_number') }}</td>
            <td>{{ __('messages.order_number') }}</td>
            <td>{{ __('messages.date') }}</td>
            <td>{{ __('messages.department') }}</td>
            <td>{{ __('messages.technician') }}</td>
            <td>{{ __('messages.payment_status') }}</td>
        </tr>
        <tr>
            <td>{{ str_pad($invoice->id, 8, '0', STR_PAD_LEFT) }}</td>
            <td>{{ str_pad($invoice->order_id, 8, '0', STR_PAD_LEFT) }}</td>
            <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
            <td>{{ $invoice->order->department->name }}</td>
            <td>{{ $invoice->order->technician->name }}</td>
            <td>{{ __('messages.' . $invoice->payment_status) }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th colspan="2">{{ __('messages.service') }}</th>
                <th>{{ __('messages.quantity') }}</th>
                <th>{{ __('messages.unit_price') }}</th>
                <th>{{ __('messages.total') }}</th>
            </tr>
        </thead>

        {{-- Services Section --}}
        @if ($invoice->invoice_details->where('service.type', 'service')->count() > 0)
            @foreach ($invoice->invoice_details->where('service.type', 'service') as $row)
                <tr>
                    @if ($loop->index == 0)
                        <td rowspan="{{ $invoice->invoice_details->where('service.type', 'service')->count() }}">
                            {{ __('messages.services') }}</td>
                    @endif
                    <td>{{ $row->service->name }}</td>
                    <td class=" text-center">{{ $row->quantity }}</td>
                    <td class="text-right">{{ number_format($row->price, 3) }}</td>
                    <td class="text-right">{{ number_format($row->quantity * $row->price, 3) }}</td>
                </tr>
            @endforeach
        @endif

        {{-- Parts Section --}}
        @if ($invoice->invoice_details->where('service.type', 'part')->count() > 0)
            @foreach ($invoice->invoice_details->where('service.type', 'part') as $row)
                <tr>
                    @if ($loop->index == 0)
                        <td rowspan="{{ $invoice->invoice_details->where('service.type', 'part')->count() }}">
                            {{ __('messages.parts') }}</td>
                    @endif
                    <td>{{ $row->service->name }}</td>
                    <td class=" text-center">{{ $row->quantity }}</td>
                    <td class="text-right">{{ number_format($row->price, 3) }}</td>
                    <td class="text-right">{{ number_format($row->quantity * $row->price, 3) }}</td>
                </tr>
            @endforeach
        @endif

        {{-- Totals --}}
        @if ($invoice->discount > 0)
            <tr>
                <th style="border: none; background:transparent" class="text-end" colspan="4">
                    {{ __('messages.discount') }}</th>
                <td class="text-right">{{ number_format($invoice->discount, 3) }}
                </td>
            </tr>
        @endif
        <tr>
            <th style="border: none; background:transparent" class="text-end" colspan="4">
                {{ __('messages.total') }}</th>
            <th class="text-right">{{ number_format($invoice->amount, 3) }}
            </th>
        </tr>
        @if ($invoice->cash_amount > 0)
            <tr>
                <th style="border: none; background:transparent" class="text-end" colspan="4">
                    {{ __('messages.cash') }}</th>
                <td class="text-right">
                    {{ number_format($invoice->cash_amount, 3) }}</td>
            </tr>
        @endif
        @if ($invoice->knet_amount > 0)
            <tr>
                <th style="border: none; background:transparent" class="text-end" colspan="4">
                    {{ __('messages.knet') }}</th>
                <td class="text-right">
                    {{ number_format($invoice->knet_amount, 3) }}</td>
            </tr>
        @endif
        <tr>
            <th style="border: none; background:transparent" class="text-end" colspan="4">
                {{ __('messages.paid_amount') }}</th>
            <td class="text-right">
                {{ number_format($invoice->payments->sum('amount'), 3) }}</td>
        </tr>
        <tr>
            <th style="border: none; background:transparent" class="text-end" colspan="4">
                {{ __('messages.remaining_amount') }}</th>
            <td class="text-right">
                {{ number_format($invoice->remaining_amount, 3) }}</td>
        </tr>
    </table>

    <p style="display: block; text-align:center; font-weight:bold;font-size:0.8rem;margin-top:5rem;">
        {{ __('messages.thanks_message') }}
    </p>
</body>

</html>
