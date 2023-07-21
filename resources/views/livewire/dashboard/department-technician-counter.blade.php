<div class=" card shadow">
    <div class="card-header">{{ __('messages.department_technician_statistics') }}</div>
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
        <div wire:poll.30s="getCounters">


            @foreach ($departments as $department)
                <table class=" table table-bordered mb-2">
                    {{-- <thead>
                        <tr class=" text-center">
                            <th>{{ __('messages.department') }} / {{ __('messages.technician') }}</th>
                            <th>{{ __('messages.completed') }}</th>
                        </tr>
                    </thead> --}}
                    <tbody>
                        <tr class=" text-center bg-light">
                            <th colspan="2">
                                <div>
                                    <div>{{ $department->name }}</div>
                                    <div class="progress m-2 border shadow-sm" style="height: 20px;">
                                        <div class="bg-success progress-bar"
                                            style="width: {{ ($department->completed_orders_count / $department->total_orders_count) * 100 }}%;">
                                            {{ $department->completed_orders_count }}
                                        </div>
                                        <div class="bg-light text-dark progress-bar"
                                            style="width:{{ 100 - ($department->completed_orders_count / $department->total_orders_count) * 100 }}%;">
                                            {{ $department->total_orders_count - $department->completed_orders_count }}
                                        </div>
                                    </div>
                                    <div>{{ $department->completed_orders_count }} /
                                        {{ $department->total_orders_count }}
                                        ({{ number_format(($department->completed_orders_count / $department->total_orders_count) * 100, 2) }}%)
                                    </div>
                                </div>
                            </th>
                        </tr>
                        @foreach ($department->technicians->sortByDesc('completed_orders_count') as $technician)
                            @if ($technician->completed_orders_count > 0)
                                <tr class=" text-center">
                                    <td>{{ $technician->name }}</td>
                                    <td>{{ $technician->completed_orders_count }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endforeach

        </div>
    </div>
</div>

@if (Route::is('reports.department_technician_statistics'))
    @section('title')
        <title>@lang('messages.department_technician_statistics')</title>
    @endsection
@endif
