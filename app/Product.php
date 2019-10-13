<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'type', 'price', 'supplier_id'];
    
    public function supplier(){
        return $this->belongsTo('App\Supplier');
    }
}
