@section('title')
    <title>{{ $department->name }}</title>
@endsection
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>{{ $department->name }} - {{ $orders->count() }} {{ __('messages.order') }}</div>
                    {{-- Loading Spinner --}}
                    <div wire:loading>
                        @include('components.spinner')
                    </div>
                </div>
                <div class="card-body">
                    {{-- Show Today's Orders Only Filter --}}
                    <div class="form-group col-md-12 col-lg-2 p-0">
                        <label for="start_created_at">{{ __('messages.created_at') }}</label>
                        <input wire:model="date_filter" type="date" id="date_filter" class="form-control">
                    </div>
                    {{-- Unassigned Orders Card --}}
                    <div class="card">
                        <div class="card-header text-center">{{ __('messages.unassigned') }}</div>
                        <div class="card-body p-0">
                            <div id="tech0" class="box unassigned_box d-flex align-items-start p-2 m-0">
                                @foreach ($orders->whereNull('technician_id')->whereNotIn('status_id', 5)->sortByDesc('id') as $order)
                                    @include('components.order')
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- Technicians --}}
                    <div class="d-flex align-items-start justify-content-start tech_list">
                        {{-- On Hold Orders Box --}}
                        <div class="card" style="min-width: 266px">
                            <div class="card-header text-center d-flex justify-content-between m-0"
                                style="background: gray">
                                <div>@lang('messages.on_hold')</div>
                            </div>
                            <div class="card-body p-0">
                                <div id="techhold" class="box tech_box d-flex flex-column p-2 m-0 align-items-center">
                                    @foreach ($orders->where('status_id', 5) as $order)
                                        @include('components.order')
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class=" d-flex">
                            @foreach ($technicians->sortBy('shift.start_time')->groupBy('shift_id') as $shift_technicians)
                                <div class="d-flex flex-column overflow-x-auto">
                                    <div class="card-header">
                                        @if ($shift_technicians->first()->shift_id)
                                            {{ $shift_technicians->first()->shift->name }}
                                            {{ __('messages.from') }}
                                            {{ date('h:i', strtotime($shift_technicians->first()->shift->start_time)) }}
                                            {{ __('messages.to') }}
                                            {{ date('h:i', strtotime($shift_technicians->first()->shift->end_time)) }}
                                        @else
                                            {{ __('messages.undefined_shift') }}
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-start">
                                        @foreach ($shift_technicians as $technician)
                                            {{-- Technician Box --}}
                                            <div class="card" style="min-width: 266px">
                                                <div class="card-header">
                                                    <div class=" d-flex align-items-center justify-content-between m-0">
                                                        <div>
                                                            <div>{{ $technician->name }}</div>
                                                            <div class=" small">@lang('messages.todays_completed') =
                                                                {{ $technician->todays_completed_orders_count }}</div>
                                                        </div>
                                                        <a href="{{ route('orders.index', ['technician_id' => [$technician->id]]) }}"
                                                            target="__blank"
                                                            class=" btn btn-info btn-sm">{{ __('messages.view_tech_orders') }}</a>
                                                    </div>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div id="tech{{ $technician->id }}"
                                                        class="box tech_box d-flex flex-column p-2 m-0 align-items-center">
                                                        @foreach ($orders->where('technician_id', $technician->id) as $order)
                                                            @include('components.order')
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
    <style>
        .box>div {
            z-index: 10;
        }

        .tech_box>.order-non-dragable,
        .gu-mirror,
        .tech_box>.order,
        .unassigned_box>.order {
            cursor: pointer;
            border-radius: 5px;
            font-size: .75rem;
            width: 250px;
            min-width: 250px;
            overflow: hidden;
        }

        .unassigned_box {
            min-height: 100px;
            overflow-y: hidden;
            overflow-x: scroll;
        }

        .tech_box {
            min-height: 250px;
        }
    </style>
@endsection

@push('scripts')
    <script src="{{ asset('vendors/sortable/Sortable.js') }}"></script>
    <script src="{{ asset('vendors/dragula/dragula.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('vendors/dragula/dragula.css') }}">
    <script>
        $(document).ready(function() {
            if (screen.width < 992) {
                loadDataFromSortableJs();
            } else {
                loadDataFromDragulaJs();
            }

            Pusher.logToConsole = true;
            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
            });
            // var channel = pusher.subscribe("OrderCreatedChannel{{ $department_id }}");
            var channel = pusher.subscribe("OrderChannel");
            channel.bind("App\\Events\\OrderEvent", (data) => {
                if (data.department_id == "{{ $department_id }}") {
                    switch (data.action) {
                        case 'order_created':
                            @this.refresh_data();
                            let title = "{{ __('messages.new_order_created') }}";
                            let body = "{{ __('messages.you_have_new_order_no') }} " + data.order_id;
                            var notification = new Notification(title, {
                                body
                            });
                            break;
                        case 'order_updated':
                            @this.refresh_data();
                            break;
                    }
                }
            });

            function loadDataFromDragulaJs() {
                const boxNodes = document.querySelectorAll('.box');
                const draggableBoxes = [].slice.call(boxNodes);
                var drake = dragula(draggableBoxes, {
                    // ignoreInputTextSelection: false,
                    moves: function(el, source, handle, sibling) {
                        return el.draggable;
                    },
                    accepts: function(el, target, source, sibling) {
                        if (sibling) {
                            return sibling.draggable;
                        } else {
                            return true;
                        }
                    }
                });
                drake.on('drop', function(order, boxTo, boxFrom) {
                    var order_id = order.id.replace('order', '');
                    var tech_id = boxTo.id.replace('tech', '');
                    // console.log(order_id,tech_id);
                    var positions = [];
                    $('#tech' + tech_id).children().each(function(index) {
                        positions.push([$(this).attr('id').replace('order', ''), index]);
                    });
                    // console.log(positions);
                    @this.change_technician(order_id, tech_id, positions);
                });
            }

            function loadDataFromSortableJs() {
                var el = $('.box');
                $(el).each(function(i, e) {
                    var sortable = Sortable.create(e, {
                        group: 'box', // set both lists to same group
                        draggable: ".order", // Specifies which items inside the element should be draggable
                        sort: true,
                        animation: 150,
                        delay: 500,
                        ghostClass: 'blue-background-class',
                        swapThreshold: 1,
                        onEnd: function( /**Event*/ evt) {
                            var order_id = evt.item.id.replace('order', '');
                            var tech_id = evt.to.id.replace('tech', '');
                            var positions = [];
                            $('#tech' + tech_id).children().each(function(index) {
                                positions.push([$(this).attr('id').replace('order', ''),
                                    index
                                ]);
                            });
                            // console.log(positions);
                            @this.change_technician(order_id, tech_id, positions);
                        },
                    });
                });
            }
        });
    </script>
@endpush
