<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'address', 'city', 'phone', 'mobile', 'notes', 'salary', 'hire_date'];

    public function orders(){
        return $this->hasMany('App\Order');
    }
}
