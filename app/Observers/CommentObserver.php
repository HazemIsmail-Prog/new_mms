<?php

namespace App\Observers;

use App\Events\OrderEvent;
use App\Events\RefreshTechnicianPageEvent;
use App\Models\Comment;

class CommentObserver
{
    public function created(Comment $comment)
    {
        event(new OrderEvent($comment->order->department_id,$comment->order->id,'order_updated'));
        event(new RefreshTechnicianPageEvent($comment->order->technician_id));
    }
}
