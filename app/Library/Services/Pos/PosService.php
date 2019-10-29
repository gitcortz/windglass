<?php

namespace App\Library\Services\Pos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\OrderItems;
use App\Cash;

class PosService implements PosServiceInterface
{
    public function createOrder(Request $request)
    {       
        $order_id = 0;
        DB::transaction(function() use(&$order_id, $request) {

          $order = Order::create([
            'order_date' => $request->order_date, 
            'address' => $request->address, 
            'city' => $request->city,
            'customer_id' => $request->customer_id,
            'pos_session_id'=>$request->posSession,
            'order_status_id'=>1,
            'payment_method_id'=>$request->payment_method_id,
            'payment_status_id'=>1,
          ]);
          
          $order_id = $order->id;
          $total_amount = 0;
          $order_items = [];
          foreach ($request->order_items as $item) {
            $order_items[] = [
              'order_id' => $order->id,     
              'product_id' => $item['product_id'],
              'unit_price' => $item['unit_price'],
              'discount' => $item['discount'],
              'quantity' => $item['quantity'],
            ];
            $total_amount = $total_amount + ($item['quantity'] * ($item['unit_price'] - $item['discount']));
          }
          OrderItems::insert($order_items);  
        
        });
        
        return $order_id;
    }

    public function cashIn(Request $request)
    {              
          $cash = Cash::create([
            'status' => 1, 
            'cash_amount' => $request->cash_amount, 
            'description' => $request->description, 
            'pos_session_id' => $request->pos_session_id
          ]);
        
        
        return $cash;
    }

    public function cashOut(Request $request)
    {              
          $cash = Cash::create([
            'status' => 2, 
            'cash_amount' => $request->cash_amount, 
            'description' => $request->description, 
            'pos_session_id' => $request->pos_session_id
          ]);
        
        
        return $cash;
    }
}