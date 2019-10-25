<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_date', 'delivered_date', 'address', 'city', 
                            'customer_id', 'pos_session_id', 'store_id',
                            'order_status_id', 'payment_status_id', 'payment_method_id'];

    public function order_items(){
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

    public function order_status(){
        return $this->belongsTo('App\OrderStatus');
    }

    public function payment_method(){
        return $this->belongsTo('App\PaymentMethod');
    }

    public function payment_status(){
        return $this->belongsTo('App\PaymentStatus');
    }
}
