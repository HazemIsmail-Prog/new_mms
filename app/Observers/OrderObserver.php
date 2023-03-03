<?php

namespace App\Observers;

use App\Events\OrderCreatedEvent;
use App\Events\OrderUpdatedPerOrderEvent;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @return void
     */
    public function created(Order $order)
    {
        if ($order->status_id != 1) {
            //only for db seeder to create first then change status to 2
            OrderStatus::create([
                'order_id' => $order->id,
                'status_id' => 1,
                'technician_id' => null,
                'user_id' => auth()->id() ?? 1,
            ]);
        }
        OrderStatus::create([
            'order_id' => $order->id,
            'status_id' => $order->status_id,
            'technician_id' => $order->technician_id,
            'user_id' => auth()->id() ?? 1,
        ]);
        event(new OrderCreatedEvent($order->department_id));
    }

    /**
     * Handle the Order "updated" event.
     *
     * @return void
     */
    public function updated(Order $order)
    {
        $latest_status_id = OrderStatus::where('order_id', $order->id)->orderByDesc('id')->first()->status_id;
        $latest_technician_id = OrderStatus::where('order_id', $order->id)->orderByDesc('id')->first()->technician_id;

        if ($order->status_id != $latest_status_id || $order->technician_id != $latest_technician_id) {
            OrderStatus::create([
                'order_id' => $order->id,
                'status_id' => $order->status_id,
                'technician_id' => $order->technician_id,
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        event(new OrderCreatedEvent($order->department_id));
        event(new OrderUpdatedPerOrderEvent($order->id));
        // if($order->index == 0){
        //     $this->toFirebase($order->technician_id, $order->id,$order->creator->name_en);
        // }
    }

    // public function toFirebase($technician_id,$order_id , $creator_name)
    // {
    //     if($technician_id){
    //         $fcm_tokens = User::find($technician_id)->fcm_tokens->pluck('fcm_token');
    //         $SERVER_API_KEY = 'AAAAW3u92M0:APA91bEgx-6fI7weETyufiuDcaof_B86B5xrN1WwPtA8cSFtxQYeJ8nIWKa8vqivAtY7XWUXCb_k36nD6gx7H0CoAVDVeZ38X6iLwGbMIVznjkmOp3BQ_xiqAorPwscmFaEJc24_DNBE';
    //         $data = [
    //             "registration_ids" => $fcm_tokens,
    //             "notification" => [
    //                 "title" => 'New Order',
    //                 "body" => ' New Order No. '. $order_id .' Assigned for you by ' . $creator_name,
    //                 "sound" => "default" // required for sound on ios
    //             ],
    //         ];
    //         $dataString = json_encode($data);
    //         $headers = [
    //             'Authorization: key=' . $SERVER_API_KEY,
    //             'Content-Type: application/json',
    //         ];
    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    //         curl_setopt($ch, CURLOPT_POST, true);
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    //         curl_exec($ch);
    //     }
    // }

    /**
     * Handle the Order "deleted" event.
     *
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
