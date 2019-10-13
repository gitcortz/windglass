<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'address', 'city', 'phone', 'mobile', 'notes'];

    protected $hidden = ['deleted_at',];

    public function pos_sessions(){
        return $this->hasMany('App\PosEssion');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }
}
