<?php

namespace App\Library\Services\Pos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\OrderItems;
use App\Cash;
use App\PosSession;
use App\InventoryStock;
use App\InventoryMovement;
use App\Dto\PosSummaryDto;
use App\Dto\PosSalesDto;

class PosService implements PosServiceInterface
{
    public function createOrder(Request $request)
    {       
        $order_id = 0;
        DB::transaction(function() use(&$order_id, $request) {
          $posSession = PosSession::find($request->posSession);
          
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
          //$order_items = [];
          foreach ($request->order_items as $item) {
            $order_item = OrderItems::create([
              'order_id' => $order->id,     
              'product_id' => $item['product_id'],
              'unit_price' => $item['unit_price'],
              'discount' => $item['discount'],
              'quantity' => $item['quantity'],
            ]);  

            $this->decreaseStock($order_item, $posSession->store_id, $item['product_id'], $item['quantity']);      
            $total_amount = $total_amount + ($item['quantity'] * ($item['unit_price'] - $item['discount']));
          }
          
        
        });
        
        return $order_id;
    }

    public function voidOrder(Request $request)
    {
        DB::transaction(function() use($request) {
          $order = Order::find($request->order_id);
          $order->order_status_id = 3;
          $order->save();
          $posSession = PosSession::find($order->pos_session_id);

          foreach ($order->order_items as $item) {
            $this->increaseStock($item, 
                                $posSession->store_id, 
                                $item['product_id'], 
                                $item['quantity']);      
          }                  
        });
        
        return "ok";
    }

    public function increaseStock($order_item, $store_id, $product_id, $quantity){
      $stock = InventoryStock::where('store_id', $store_id)
                            ->where('product_id', $product_id)
                            ->first();
      $before = $stock->current_stock;
      $after = $stock->current_stock + $quantity;
      $stock->current_stock = $after;
      $stock->save();

      $stockMovement = InventoryMovement::create([
        'stock_id' => $stock->id, 
        'before' => $before, 
        'after' => $after, 
        'reason_type' => 'void', 
        'reason' => '',
        'order_item_id' => $order_item->id
      ]); 
    }

    public function decreaseStock($order_item, $store_id, $product_id, $quantity){
      $stock = InventoryStock::where('store_id', $store_id)
                            ->where('product_id', $product_id)
                            ->first();
      $before = $stock->current_stock;
      $after = $stock->current_stock - $quantity;
      $stock->current_stock = $after;
      $stock->save();

      $stockMovement = InventoryMovement::create([
        'stock_id' => $stock->id, 
        'before' => $before, 
        'after' => $after, 
        'reason_type' => 'order', 
        'reason' => '',
        'order_item_id' => $order_item->id
      ]); 
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

    public function summary($pos_session_id)
    {       
        $posSession = PosSession::find($pos_session_id);

        $order_items = DB::table('orders')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select('order_items.*', 'products.name as product_name', 
                        'orders.payment_status_id')
                ->where('orders.pos_session_id', $pos_session_id)
                ->get();

        $cashes = DB::table('cashes')
              ->select('cashes.*')
              ->where('cashes.pos_session_id', $pos_session_id)
              ->get();

        $pos_summary = new PosSummaryDto($posSession, $order_items, $cashes);
        
        return $pos_summary;
    }

    public function sales($pos_session_id)
    {       
        //$posSession = PosSession::find($pos_session_id);

        $order_items = DB::table('orders')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select('order_items.*', 'products.name as product_name', 
                        'orders.payment_status_id')
                ->where('orders.pos_session_id', $pos_session_id)
                ->get();

        $pos_sales = new PosSalesDto($order_items);
        
        return $pos_sales;
    }
}