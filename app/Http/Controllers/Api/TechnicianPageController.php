<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class TechnicianPageController extends Controller
{
    public function getCurrenOrder()
    {
        $order = Order::query()
            ->where('technician_id', auth()->id())
            ->whereIn('status_id', [2, 3])
            ->orderBy('index')
            ->first();

        if ($order) {
            $data = new OrderResource($order);
        } else {
            $data = [];
        }

        return response(['data' => $data, 'error' => 0, 'message' => 'Success']);
    }

    public function accept(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->update(['status_id' => 3]);

        return response(['error' => 0, 'message' => 'Success']);
    }

    public function complete(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->update([
            'status_id' => 4,
            'completed_at' => now(),
            'index' => null,
        ]);

        return response(['error' => 0, 'message' => 'Success']);
    }
}
