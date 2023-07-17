<div class="card shadow">
    <div class="card-header">{{ __('messages.order_comments') }}</div>
    <div class="card-body">
        @forelse($comments as $row)
            @if ($row->user_id == auth()->id())
                <div class=" d-flex flex-row-reverse">
                    <div class=" align-self-center" style="font-size: 0.7rem;flex:1">
                        <div style="text-align:end">{{ $row->created_at->format('d-m-Y') }}</div>
                        <div style="text-align:end">{{ $row->created_at->format('H:i') }}</div>
                    </div>
                    <div class="d-flex flex-column" style="gap:0;flex:4">
                        <div style="border-radius: 5px;max-width: 100%;background-color:#7be79a;color:black;"
                            class="
                            shadow-sm px-3 py-1 align-self-start rounded-3">
                            {{ $row->comment }}</div>
                    </div>
                </div>
            @else
                <div class=" d-flex">
                    <div class=" align-self-center" style="font-size: 0.7rem;flex:1">
                        <div>{{ $row->created_at->format('d-m-Y') }}</div>
                        <div>{{ $row->created_at->format('H:i') }}</div>
                    </div>
                    <div class="d-flex flex-column" style="gap:0;flex:4">
                        <div style="border-radius:5px;font-size:0.6rem;"
                            class="px-3 py-1 w-fit align-self-end px-2 py-1 bg-dark text-white rounded-3">
                            {{ @$row->user->name }}</div>
                        <div style="border-radius: 5px;max-width: 100%;"
                            class=" shadow-sm px-3 py-1  align-self-end bg-light rounded-3">{{ $row->comment }}</div>
                    </div>
                </div>
            @endif
        @empty
            <div class=" mb-3 text-center">{{ __('messages.no_comments_found') }}</div>
        @endforelse
        <form wire:submit.prevent="send" class=" d-flex">
            <input wire:model="comment" class=" form-control" type="text">
            <button type="submit" class="btn btn-facebook btn-sm">{{ __('messages.send') }}</button>
        </form>
    </div>
</div>
