<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'store_id' => $this->store_id,
            'current_stock' =>  $this->current_stock,
            'stock_status_id' =>  $this->stock_status_id,
            'product' => new ProductResource($this->product)
          ];
    }
}
