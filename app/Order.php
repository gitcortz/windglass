<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_date', 'delivered_date', 'address', 'customer_id', 'pos_session_id', 'store_id'];

    public function orderItems(){
        return $this->hasMany('App\OrderItems');
    }

    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function customer(){
        return $this->belongsTo('App\Customer');
    }

    public function rider(){
        return $this->belongsTo('App\Employee');
    }
}
