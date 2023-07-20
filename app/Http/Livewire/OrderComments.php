<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderComments extends Component
{
    public $order_id;
    public $order;
    public $comments;
    public $comment;

    protected $listeners = ['order_updated' => 'refresh'];

    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->order = Order::find($this->order_id);
        $this->comments = $this->order->comments->load('user');
    }
    
    public function send()
    {
        $this->validate(['comment' => 'required']);
        $this->order->comments()->create([
            'comment' => $this->comment,
            'user_id' => auth()->id(),
            'is_read' => false,
        ]);
        $this->comment = '';
        $this->refresh();
    }

    public function render()
    {
        return view('livewire.order-comments');
    }
}
