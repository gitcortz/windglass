<?php

namespace App\Library\Services\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\InventoryStock;
use App\InventoryMovement;

class InventoryService implements InventoryServiceInterface
{
    public function createStock(Request $request){
        
        $stock_id = 0;
        
        DB::transaction(function() use(&$stock_id, $request) {
            $stock = InventoryStock::create([
                'store_id' => $request->store, 
                'product_id' => $request->product_id, 
                'initial_stock' => $request->initial_stock, 
                'current_stock' => $request->initial_stock, 
                'stock_status_id' => 1
            ]);
            $stock_id = $stock->id;

            $stockMovement = InventoryMovement::create([
                'stock_id' => $stock_id, 
                'before' => 0, 
                'after' => $request->initial_stock, 
                'reason_type' => 'initial', 
                'reason' => '', 
                'from_stock_id' => $request->from_stock_id, 
            ]);
            
            if ($request->from_stock_id) {
                $fromStock = InventoryStock::find($request->from_stock_id);
                $before =  $fromStock->current_stock;
                $after = $fromStock->current_stock - $request->initial_stock;
                $fromStock->current_stock = $after;
                $fromStock->save();

                $stockMovement = InventoryMovement::create([
                    'stock_id' => $request->from_stock_id, 
                    'before' => $before, 
                    'after' => $after, 
                    'reason_type' => 'move', 
                    'reason' => ''
                ]); 
            }
        });
        
        return $stock_id;
          
    }

    public function moveStock(Request $request){
        
        $fromStock = InventoryStock::find($request->from_stock_id);
        $toStock = InventoryStock::find($request->to_stock_id);
        
        if ($fromStock && $toStock  
            && $fromStock->current_stock > $request->quantity
            && $fromStock->product_id == $toStock->product_id) 
        {
            DB::transaction(function() use($fromStock, $toStock, $request) {
                $from_before = $fromStock->current_stock;
                $from_after = $fromStock->current_stock - $request->quantity;
                $fromStock->current_stock = $from_after;
                $fromStock->save();
                $to_before = $toStock->current_stock;
                $to_after = $toStock->current_stock + $request->quantity;
                $toStock->current_stock = $to_after;
                $toStock->save();

                $stockMovement = InventoryMovement::create([
                    'stock_id' => $fromStock->id, 
                    'before' => $from_before, 
                    'after' => $from_after, 
                    'reason_type' => 'move', 
                    'reason' => ''
                ]); 

                $stockMovement = InventoryMovement::create([
                    'stock_id' => $toStock->id, 
                    'before' => $to_before, 
                    'after' => $to_after, 
                    'reason_type' => 'move', 
                    'reason' => ''
                ]); 

            });

            return "ok";
        } 
        else 
        {
            return "fail";
        }          
    }

    
}