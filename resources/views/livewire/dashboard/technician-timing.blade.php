<div class=" card shadow">
    <div class="card-header">{{ __('messages.technician_timing') }}</div>
    <div class="card-body">
        <div class="d-flex">
            <div class=" form-group w-100">
                <label for="technician">{{ __('messages.technician') }}</label>
                <select id="technician" wire:model="technician" class=" form-control form-control-sm">
                    <option value="">---</option>
                    @foreach ($technicians as $technician)
                        <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class=" form-group w-100">
                <label for="month">{{ __('messages.month') }}</label>
                <select id="month" wire:model="month" class=" form-control form-control-sm">
                    <option value="01">1</option>
                    <option value="02">2</option>
                    <option value="03">3</option>
                    <option value="04">4</option>
                    <option value="05">5</option>
                    <option value="06">6</option>
                    <option value="07">7</option>
                    <option value="08">8</option>
                    <option value="09">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>
            <div class=" form-group w-100">
                <label for="year">{{ __('messages.year') }}</label>
                <select id="year" wire:model="year" class=" form-control form-control-sm">
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
        </div>
        <div class=" table-responsive">
            <table class=" table border table-bordered m-0">
                <thead>
                    <tr class=" bg-light">
                        <th width="5%" class=" text-center align-middle">{{ __('messages.order_number') }}</th>
                        <th width="45%" class=" text-center align-middle">{{ __('messages.order_description') }}</th>
                        <th width="10%" class=" text-center align-middle">{{ __('messages.received_time') }}</th>
                        <th width="10%" class=" text-center align-middle">{{ __('messages.arrived_time') }}</th>
                        <th width="10%" class=" text-center align-middle">{{ __('messages.completed_time') }}</th>
                        <th width="10%" class=" text-center align-middle">{{ __('messages.receiveToComplete') }}</th>
                        <th width="10%" class=" text-center align-middle">{{ __('messages.arriveToComplete') }}</th>
                    </tr>
                </thead>
                <tbody wire:poll.60000ms="getOrders">
                    @forelse ($orders as $order)
                        <tr>
                            <td nowrap class="text-center">{{ $order->id }}</td>
                            <td>{{ $order->order_description }}</td>
                            <td nowrap class="text-center">
                                <div>{{ $order->latest_received->created_at->format('d-m-Y') }}</div>
                                <div>{{ $order->latest_received->created_at->format('H:i') }}</div>
                            </td>
                            <td nowrap class="text-center">
                                @if ($order->latest_arrived)
                                    <div>{{ $order->latest_arrived->created_at->format('d-m-Y') }}</div>
                                    <div>{{ $order->latest_arrived->created_at->format('H:i') }}</div>
                                @else
                                    -
                                @endif
                            </td>
                            <td nowrap class="text-center">
                                <div>{{ $order->completed_at->format('d-m-Y') }}</div>
                                <div>{{ $order->completed_at->format('H:i') }}</div>
                            </td>
                            <td nowrap class="text-center">{{ $order->receiveToComplete }}</td>
                            <td nowrap class="text-center">{{ $order->arriveToComplete }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class=" text-center">{{ __('messages.no_orders') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if (Route::is('reports.technician_timing'))
    @section('title')
        <title>@lang('messages.technician_timing')</title>
    @endsection
@endif
