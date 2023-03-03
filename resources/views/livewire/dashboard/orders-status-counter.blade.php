<div class=" card shadow">
    <div class="card-header">{{ __('messages.monthly_orders_statistics') }}</div>
    <div class="card-body">
        <div class="d-flex">
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
                        <th class=" text-center align-middle">{{ __('messages.date') }}</th>
                        @foreach ($statuses as $status)
                            <th class=" text-center align-middle">{{ $status->name }}</th>
                        @endforeach
                        <th class=" text-center align-middle">{{ __('messages.total') }}</th>
                    </tr>
                </thead>
                <tbody wire:poll.60000ms="getCounters">
                    @forelse ($counters->groupBy('date') as $row)
                        <tr>
                            <th nowrap class=" text-center bg-light">
                                <div>{{ __('messages.' . date('l', strtotime($row[0]->date))) }}</div>
                                <div>{{ date('d-m-Y', strtotime($row[0]->date)) }}</div>
                            </th>
                            @foreach ($statuses as $status)
                                <td class=" text-center">
                                    {{ $row->where('status_id', $status->id)->pluck('count')->first() }}</td>
                            @endforeach
                            <th class=" text-center bg-light">{{ $row->sum('count') }}</th>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class=" text-center">{{ __('messages.no_orders') }}</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class=" bg-light">
                        <th class=" text-center align-middle">{{ __('messages.total') }}</th>
                        @foreach ($statuses as $status)
                            <th class=" text-center align-middle">
                                {{ $counters->where('status_id', $status->id)->sum('count') }}</th>
                        @endforeach
                        <th class=" text-center align-middle">
                            {{ $counters->sum('count') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@if (Route::is('reports.monthly_orders_statistics'))
    @section('title')
        <title>@lang('messages.monthly_orders_statistics')</title>
    @endsection
@endif
