<div x-data="{ open: false }">

    <li  class="c-header-nav-item dropdown">
        <a 
            @click="open = ! open" 
            class="c-header-nav-link"
        >
            <svg class="c-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speech') }}"></use>
            </svg>
            @if ($total_unread_messages > 0)
                <div 
                    class="bg-danger"
                    style="
                        position: absolute;
                        top: -10px;
                        right: -3px;
                        border-radius: 4px;
                        padding: 2px 5px 0px 5px;
                        display: flex;
                        font-size: 10px;
                ">
                    {{ $total_unread_messages }}
                </div>
            @endif
        </a>
        <div  
            x-show="open"
            x-collapse.duration.100ms
            x-on:click.outside="open = false"
            style="
                display:none;
                width: 290px;
                padding: 0px;
                position: absolute;
                {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 0px;
        ">
            <div x-data="{selected:null}">
                @foreach ($users as $user)
                    <div class="card bg-light mb-0">
                        <div
                            @click="selected !== {{ $user->id }} ? selected = {{ $user->id }} : selected = null"
                            wire:click="setSelectedUser({{ $user->id }})"
                            class=" mb-0 py-2 px-3 d-flex justify-content-between" 
                            style="cursor: pointer"
                        >
                            <div>{{ $user->name }}</div>
                            @if ($user->unread_messeges > 0)
                                <div class="badge badge-danger px-2 d-flex mb-0 align-items-center">
                                    {{ $user->unread_messeges }}
                                </div>
                            @endif
                        </div>
                        <div x-bind:style="selected == {{ $user->id }} ? 'display:block !important' : 'display:none' " >
                            <div 
                                class="card-body border-top mb-0 p-2 d-flex flex-column justify-content-between"
                                style="height: 300px;"
                            >
                                <div 
                                    class="messages-container bg-light mb-0 p-2 overflow-auto"
                                    id="messages{{ $user->id }}"
                                >
                                    @foreach ($messages as $message)
                                        <div
                                            {{-- wire:loading.remove --}}
                                            class="message {{ $message->sender_user_id == $user->id ? 'received' : 'sent' }}">
                                            <div>{{ $message->message }}</div>
                                            @if ($message->sender_user_id == auth()->id())
                                                <div class="d-flex mb-0"
                                                    style="
                                            gap: 0;
                                            {{ $message->read == 1 ? 'color:blue;' : '' }}
                                            justify-content: end;
                                            font-size: 8px;
                                            margin-top: -3px;">
                                                    <div
                                                        style="margin-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: -3px;">
                                                        ✓</div>
                                                    <div>✓</div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class=" d-flex">
                                    <input wire:keydown.enter="sendMessageTo({{ $user->id }})"
                                        wire:model.defer="message.{{ $user->id }}" type="text"
                                        class=" form-control p-1">
                                    <button wire:click="sendMessageTo({{ $user->id }})"
                                        class=" btn btn-facebook">@lang('messages.send')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </li>
</div>





@push('scripts')
    <script>


            // Pusher.logToConsole = true;
            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
            });
            var channel = pusher.subscribe("MessageSentToEventChannel{{ auth()->id() }}");
            var callback = (eventName, data) => {
                @this.referehData();

            };
            channel.bind_global(callback);

        window.addEventListener('scrollToBottom', event => {
            scrollToBottom(event.detail.user_id);
        })

        window.addEventListener('user_selected', event => {
            setLocalStorageForCurrentUser(event.detail.user_id);

        })

        function scrollToBottom(userId) {
            var element = document.getElementById('messages' + userId);
            element.scrollTop = element.scrollHeight;
        }

        function setLocalStorageForCurrentUser(userId) {
            // localStorage.setItem("selected_user", userId );
        }
    </script>
@endpush
