<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'first_name' => $this->first_name,
            'larst_name' => $this->last_name,
            'address' => $this->address,
            'city' => $this->ciy,
            'phone' => $this->phone,
            'mobile' => $this->mobile,     
          ];
    }
}