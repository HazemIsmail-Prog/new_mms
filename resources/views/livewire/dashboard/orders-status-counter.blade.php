<div class=" card shadow">
    <div class="card-header">{{ __('messages.monthly_orders_statistics') }}</div>
    <div class="card-body">
        <div class="d-flex">
            <div class=" form-group w-100">
                <label for="month">{{ __('messages.month') }}</label>
                <select id="month" wire:model="selected_month" class=" form-control form-control-sm">
                    @foreach ($months as $month)
                        <option value="{{ $month }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            <div class=" form-group w-100">
                <label for="year">{{ __('messages.year') }}</label>
                <select id="year" wire:model="selected_year" class=" form-control form-control-sm">
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class=" table-responsive">
            <table class=" table border table-bordered m-0">
                <thead>
                    <tr class=" bg-light">
                        <th class=" text-center align-middle">{{ __('messages.date') }}</th>
                        @foreach ($statuses as $status)
                            <th width="8%" class=" text-center align-middle">{{ $status->name }}</th>
                        @endforeach
                        <th width="8%" class=" text-center align-middle">{{ __('messages.total') }}</th>
                    </tr>
                </thead>
                <tbody wire:poll.30s="getCounters">
                    @forelse ($orders->groupBy('date') as $row)
                        <tr>
                            <th nowrap class=" text-center bg-light">
                                <div>{{ __('messages.' . date('l', strtotime($row[0]->date))) }}</div>
                                <div>{{ date('d-m-Y', strtotime($row[0]->date)) }}</div>
                            </th>
                            @foreach ($statuses as $status)
                                <td class=" text-center">
                                    {{ $row->where('status_id', $status->id)->pluck('count')->first() > 0? number_format($row->where('status_id', $status->id)->pluck('count')->first()): '-' }}
                                </td>
                            @endforeach
                            <th class=" text-center bg-light">
                                {{ $row->sum('count') > 0 ? number_format($row->sum('count')) : '-' }}</th>
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
                                {{ $orders->where('status_id', $status->id)->sum('count') > 0 ? number_format($orders->where('status_id', $status->id)->sum('count')) : '-' }}
                            </th>
                        @endforeach
                        <th class=" text-center align-middle">
                            {{ $orders->sum('count') > 0 ? number_format($orders->sum('count')) : '-' }}</th>
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
