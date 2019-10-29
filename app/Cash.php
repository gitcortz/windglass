<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $fillable = ['status', 'cash_amount', 'description', 'pos_session_id'];

    public function pos_session(){
        return $this->belongsTo('App\PosSession');
    }

}
