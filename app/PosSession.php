<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosSession extends Model
{
    protected $fillable = ['store_id', 'start_balance', 'end_balance', 'pos_status', 'closed_at'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function store(){
        return $this->belongsTo('App\Store');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }
}
