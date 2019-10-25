<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'discount' =>  $this->discount,
            'quantity' =>  $this->quantity,
            'unit_price' =>  $this->unit_price,
            'quantity' =>  $this->quantity,
            'product' => new ProductResource($this->product)
          ];
    }
}
