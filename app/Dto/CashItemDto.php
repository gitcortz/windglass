<?php

namespace App\Dto;
use Illuminate\Database\Eloquent\Collection;

class CashItemDto implements \JsonSerializable
{
    private $status;    
    private $cash_amount;
    private $description;

    public function __construct($cash_item)
    {
        $this->status = $cash_item->status;
        $this->cash_amount = $cash_item->cash_amount;
        $this->description = $cash_item->description;
        
    }

    public function getCashStatus($status){
        switch ($status) {
            case "in":
                return "cash-in";
            case "out":
                return "cash-out";
            default:
                return "";
        }
    }

    public function jsonSerialize()
    {
        return [
                'status' => $this->getCashStatus($this->status),  
                'description' => $this->description,  
                'amount' => number_format($this->cash_amount, 2),                
            ];
    }
}

