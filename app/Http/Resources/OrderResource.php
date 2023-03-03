<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'orderNumber' => str_pad($this->id, 8, '0', STR_PAD_LEFT),
            'customerName' => $this->customer->name,
            'phoneNumber' => $this->phone->number,
            'address' => $this->address->full_address(),
            'addressMap' => $this->address->maps_search(),
            'statusId' => $this->status_id,
            'notes' => $this->notes,
            'orderDescription' => $this->order_description,
        ];
    }
}
