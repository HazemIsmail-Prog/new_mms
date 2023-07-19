<div class=" card shadow">
    <div class="card-header">{{ __('messages.department_technician_statistics') }}</div>
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
        <table class=" table table-bordered m-0">
            <thead>
                <tr class=" text-center">
                    <th>{{ __('messages.department') }} / {{ __('messages.technician') }}</th>
                    <th>{{ __('messages.completed') }}</th>
                </tr>
            </thead>
            <tbody wire:poll.30s="getCounters">
                @foreach ($departments as $department)
                    <tr class=" bg-light text-center">
                        <td>{{ $department->name }}</td>
                        <td>{{ $department->completed_orders_count }}</td>
                    </tr>
                    @foreach ($department->technicians->sortByDesc('completed_orders_count') as $technician)
                        @if ($technician->completed_orders_count > 0)
                            <tr class=" text-center">
                                <td>{{ $technician->name }}</td>
                                <td>{{ $technician->completed_orders_count }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if (Route::is('reports.department_technician_statistics'))
    @section('title')
        <title>@lang('messages.department_technician_statistics')</title>
    @endsection
@endif
