<?php

namespace App\Http\Livewire;

use App\Events\MessageSentToEvent;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class ChattingIndex extends Component
{
    public $users;
    public $message;
    public $messages = [];
    public $selected_user;
    public $total_unread_messages;

    public function render()
    {
        return view('livewire.chatting-index');
    }

    public function mount()
    {
        $this->referehData();
    }

    public function referehData()
    {
        // Get Users List with Count of Unread Messages for each User
        $this->users = User::query()
            ->where('id', '!=', auth()->id())
            ->whereNotIn('title_id', [10, 11])
            ->withCount(['messages as unread_messeges' => function ($q) {
                $q->where('receiver_user_id', auth()->id());
                $q->where('read', 0);
            }])
            ->get();

        // Get Total Count of Unread Messages
        $this->total_unread_messages = Message::where('read', 0)->where('receiver_user_id', auth()->id())->count();

        // Get Current Selected User Messages if the chat is open
        // Should be after above to counts so the user can notice that there are new messages
        if ($this->selected_user > 0) {
            $user = User::find($this->selected_user);
            $this->messages = $user->messages()
            ->where(function ($q) {
                $q->where('receiver_user_id', auth()->id());
                $q->orWhere('sender_user_id', auth()->id());
            })
            ->get();

            // Scroll to bottom after getting messages
            $this->dispatchBrowserEvent('scrollToBottom', ['user_id' => $this->selected_user]);
        }
    }

    public function sendMessageTo($receiver_id)
    {
        if ($this->message && $this->message != '') {
            Message::create([
                'sender_user_id' => auth()->id(),
                'receiver_user_id' => $receiver_id,
                'message' => $this->message[$receiver_id],
            ]);
            event(new MessageSentToEvent($receiver_id));
            $this->message[$receiver_id] = '';
            $this->referehData();
            $this->dispatchBrowserEvent('scrollToBottom', ['user_id' => $this->selected_user]);
        }
    }

    public function setSelectedUser($user_id)
    {
        // Set Selected User to Null When Close User's Chat Screen
        if ($this->selected_user == $user_id) {
            $this->selected_user = null;
            $this->referehData();
        } else {
            $this->selected_user = $user_id;
            $this->markAsRead($user_id);
            event(new MessageSentToEvent($user_id));
            $this->referehData();
            $this->dispatchBrowserEvent('scrollToBottom', ['user_id' => $this->selected_user]);
        }
        $this->dispatchBrowserEvent('user_selected', ['user_id' => $this->selected_user]);
    }

    public function markAsRead($user_id)
    {
        Message::query()
            ->where('receiver_user_id', auth()->id())
            ->where('sender_user_id', $user_id)
            ->where('read', 0)
            ->update(['read' => 1]);
    }
}
