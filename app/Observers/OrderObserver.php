<?php

namespace App\Observers;

use App\Events\OrderEvent;
use App\Events\RefreshTechnicianPageEvent;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;

class OrderObserver
{
    public function created(Order $order)
    {
        //only for db seeder to create first then change status to 2
        if ($order->status_id != 1) {
            OrderStatus::create([
                'order_id' => $order->id,
                'status_id' => 1,
                'technician_id' => null,
                'user_id' => auth()->id() ?? 1,
            ]);
        }

        // to add order_status record with status id 1 when creating new order
        OrderStatus::create([
            'order_id' => $order->id,
            'status_id' => $order->status_id,
            'technician_id' => $order->technician_id,
            'user_id' => auth()->id() ?? 1,
        ]);
        event(new OrderEvent($order->department_id, $order->id, 'order_created'));
    }

    public function updated(Order $order)
    {
        // to add order_status record only if status id changed or technecian id changed
        if ($order->isDirty('status_id') || $order->isDirty('technician_id')) {
            OrderStatus::create([
                'order_id' => $order->id,
                'status_id' => $order->status_id,
                'technician_id' => $order->technician_id,
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        event(new OrderEvent($order->department_id, $order->id, 'order_updated'));

        // if ($order->isDirty('index') || $order->isDirty('technician_id')) {
        //     $new_technician = User::find($order->technician_id);
        //     $old_technician = User::find($order->getOriginal('technician_id'));

            
        //     // if ($new_technician->id === $old_technician->id) {
        //     //     dd($new_technician->id, $old_technician->id);
        //     //     // event(new RefreshTechnicianPageEvent($new_technician->id));
        //     //     return;
        //     // }
        //     if ($new_technician->current_order_for_technician->id == $order->id) {
        //         event(new RefreshTechnicianPageEvent($new_technician->id));
        //     }

        //     if($old_technician){

        //         event(new RefreshTechnicianPageEvent($old_technician->id));
        //     }

        // }

        // to send event to technician page only for the first order
        // if($order->index == 0){

        //     // to send only one event if the technician not changed
        //     if($new_technician_id == $old_technician_id){
        //         event(new RefreshTechnicianPageEvent($new_technician_id));
        //     }else{
        //         event(new RefreshTechnicianPageEvent($new_technician_id));
        //         event(new RefreshTechnicianPageEvent($old_technician_id));
        //     }
        // }
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
}
