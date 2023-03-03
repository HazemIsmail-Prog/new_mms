<div class="card shadow">
    <div class="card-header">{{ __('messages.order_comments') }} - {{ $order->id }}</div>
    <div class="card-body">
        <table class="table table-borderless table-striped">
            <tbody>
                @forelse($comments as $row)
                    <tr>
                        <td class="text-center">{{ $row->comment }}</td>
                        <td nowrap class="text-center">{{ @$row->user->name }}</td>
                        <td nowrap class="text-center">
                            <div>{{ $row->created_at->format('d-m-Y') }}</div>
                            <div>{{ $row->created_at->format('H:i') }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">{{ __('messages.no_comments_found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class=" d-flex">
            <input wire:model="comment" class=" form-control" type="text">
            <button wire:click="send" class="btn btn-facebook btn-sm">{{ __('messages.send') }}</button>
        </div>
    </div>
</div>


@if (Route::is('orders.show'))
    @push('scripts')
        <script>
            Pusher.logToConsole = true;
            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
            });
            var channel = pusher.subscribe("CommentAddedChannel{{ $order->id }}");
            var callback = (eventName, data) => {
                @this.refresh();
            };
            channel.bind_global(callback);
        </script>
    @endpush

    
{{-- To Enable inline scripts for nested livewire component --}}
@else 
    <script>
        Pusher.logToConsole = true;
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });
        var channel = pusher.subscribe("CommentAddedChannel{{ $order->id }}");
        var callback = (eventName, data) => {
            @this.refresh();
        };
        channel.bind_global(callback);
    </script>
@endif
