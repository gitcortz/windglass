<?php

namespace App\Dto;
use App\PosSession;
use Illuminate\Database\Eloquent\Collection;

class PosSummaryDto implements \JsonSerializable
{

    private $start_balance;
    private $total_cash_in;
    private $total_cash_out;
    private $total_payment;
    private $pos_session;
    private $order_items;

    public function __construct(PosSession $pos_session, $order_items, $cash_items)
    {
        $this->pos_session = $pos_session;
        $this->start_balance =  $this->pos_session->start_balance;
        $this->orderItemToDTO($order_items);
        $this->cashItemToDTO($cash_items);
    }

    private function orderItemToDTO($order_items) {
        $this->total_sales = 0;
        $this->total_payment = 0;
        $orderItemCollection = array();
        foreach ($order_items as $order_item) {
            $orderItemDto = new OrderItemDto($order_item);
            $this->total_sales += $orderItemDto->getTotal();
            if ($order_item->payment_status_id == 2)
                $this->total_payment += $orderItemDto->getTotal();        
            array_push($orderItemCollection, $orderItemDto);            
        }
        $this->order_items = $orderItemCollection;        
    }

    private function cashItemToDTO($cash_items) {
        $this->total_cash_in = 0;
        $this->total_cash_out = 0;

        $cashItemCollection = array();
        foreach ($cash_items as $cash_item) {
            $cashItemDto = new CashItemDto($cash_item);            
            if ($cash_item->status == "in")
                $this->total_cash_in += $cash_item->cash_amount;        
            else
                $this->total_cash_out += $cash_item->cash_amount;
            array_push($cashItemCollection, $cashItemDto);            
        }
        $this->cash = $cashItemCollection;        
    }

    public function getBalance() 
    {
        $output = $this->start_balance + $this->total_payment + $this->total_cash_in - $this->total_cash_out;
        return $output;
    }
   
  
    public function jsonSerialize()
    {
        return [
            'sales' => [
                'total_sales' => number_format(round($this->total_sales, 2), 2),
                'sales' => $this->order_items
            ],
            'payments' => [
                'total_received' => number_format($this->total_payment, 2),
                'payments' => $this->total_payment
            ],
            'cash' => [
                'cash' => $this->cash
            ],
            'balance'  => [
                'opening_balance' => $this->start_balance,
                'payment_total' => $this->total_payment,
                'cash_in_total' => number_format($this->total_cash_in, 2),
                'cash_out_total' => number_format($this->total_cash_out, 2),
                'closing_balance' => number_format(
                                $this->pos_session->end_balance== null
                                ? $this->getBalance() 
                                : $this->pos_session->end_balance                               
                                , 2)
            ],
        ];
    }
}

