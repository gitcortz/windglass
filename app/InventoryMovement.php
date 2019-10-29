<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $fillable = ['stock_id', 'user_id', 'before', 'after', 
                'reason_type', 'reason', 'from_stock_id', 'order_item_id'];

    public function order_item(){
        return $this->belongsTo('App\OrderItems');
    }
    public function stock(){
        return $this->belongsTo('App\InventoryStock');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function fromStock(){
        return $this->belongsTo('App\InventoryStock');
    }
}

