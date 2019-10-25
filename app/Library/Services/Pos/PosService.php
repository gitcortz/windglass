<?php

namespace App\Library\Services\Pos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\OrderItems;

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
            'store_id'=>$request->store_id,
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


    
}