<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryStock extends Model
{
    protected $fillable = ['store_id', 'product_id', 'initial_stock', 'current_stock', 'stock_status_id'];

    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function status(){
        return $this->belongsTo('App\StockStatus');
    }

}
