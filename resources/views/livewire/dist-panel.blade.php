@section('title')
    <title>{{ $department->name }}</title>
@endsection
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>{{ $department->name }}</div>
                    {{-- Loading Spinner --}}
                    <div wire:loading>
                        @include('components.spinner')
                    </div>
                </div>
                <div class="card-body">
                    {{-- Show Today's Orders Only Filter --}}
                    <div class="form-check mb-2">
                        <input wire:model="todays_orders_only" class="form-check-input" type="checkbox" name="active"
                            id="todays_orders_only">
                        <label class="form-check-label"
                            for="todays_orders_only">{{ __('messages.todays_orders_only') }}</label>
                    </div>
                    {{-- Unassigned Orders Card --}}
                    <div class="card">
                        <div class="card-header text-center">{{ __('messages.unassigned') }}</div>
                        <div class="card-body p-0">
                            <div id="tech0" class="box unassigned_box d-flex align-items-start p-2 m-0">
                                @foreach ($orders->whereNull('technician_id')->whereNotIn('status_id', 5) as $order)
                                    @include('components.order')
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- Technicians --}}
                    <div class="d-flex align-items-start justify-content-start tech_list" style="overflow: auto">
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
                        @foreach ($technicians as $technician)
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
            var channel = pusher.subscribe("OrderCreatedChannel{{ $department_id }}");
            var callback = (eventName, data) => {
                @this.refresh_data();
            };
            channel.bind_global(callback);

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
