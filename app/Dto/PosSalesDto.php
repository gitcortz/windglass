<?php

namespace App\Dto;
use App\PosSession;
use Illuminate\Database\Eloquent\Collection;

class PosSalesDto implements \JsonSerializable
{

    private $total_sales;

    public function __construct($order_items)
    {
        $this->orderItemToDTO($order_items);
    }

    private function orderItemToDTO($order_items) {
        $this->total_sales = 0;        
        $orderItemCollection = array();
        foreach ($order_items as $order_item) {
            $orderItemDto = new OrderItemDto($order_item);
            $this->total_sales += $orderItemDto->getTotal();
            array_push($orderItemCollection, $orderItemDto);            
        }
        $this->order_items = $orderItemCollection;        
    }   
  
    public function jsonSerialize()
    {
        return [
            'sales' => [
                'total_sales' => number_format(round($this->total_sales, 2), 2),
                'sales' => $this->order_items
            ],
        ];
    }
}

