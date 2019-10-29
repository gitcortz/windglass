<?php

namespace App\Dto;
use Illuminate\Database\Eloquent\Collection;

class OrderItemDto implements \JsonSerializable
{
    private $quantity;    
    private $unit_price;
    private $discount;
    private $product;
    private $amount;
    private $order_id;

    public function __construct($order_item)
    {
        $this->order_id = $order_item->order_id;
        $this->quantity = $order_item->quantity;
        $this->unit_price = $order_item->unit_price;
        $this->discount = $order_item->discount;
        $this->product = $order_item->product_name;
        
    }

    public function getTotal() 
    {
        return round($this->quantity * ($this->unit_price - $this->discount), 2);
    }
   
    public function jsonSerialize()
    {
        return [
                'order_id' => $this->order_id,  
                'product' => $this->product,  
                'quantity' => $this->quantity,
                'unit_price' => $this->unit_price,
                'discount' => $this->discount,
                'amount' => number_format($this->getTotal(), 2),            
            ];
    }
}

