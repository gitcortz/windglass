<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'address', 'city', 'phone', 'mobile', 'notes'];

    public function orders(){
        return $this->hasMany('App\Order');
    }

}
