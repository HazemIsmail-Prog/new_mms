<?php

namespace App\Http\Livewire;

use App\Events\CommentAddedEvent;
use App\Events\OrderCreatedEvent;
use App\Events\OrderUpdatedPerOrderEvent;
use App\Models\Order;
use Livewire\Component;

class OrderComments extends Component
{

    public $order_id;
    public $order;
    public $comments;
    public $comment;

    public function mount()
    {

        $this->refresh();
    }

    public function refresh()
    {
        $this->order = Order::find($this->order_id);
        $this->comment = '';
        $this->comments = $this->order->comments->load('user');
    }

    public function send()
    {
        $this->validate(['comment' => 'required']);
        $this->order->comments()->create([
            'comment' => $this->comment,
            'user_id' => auth()->id(),
        ]);
        $this->refresh();
        event(new CommentAddedEvent($this->order_id));


    }

    public function render()
    {
        return view('livewire.order-comments');
    }
}