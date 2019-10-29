<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockStatus extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
