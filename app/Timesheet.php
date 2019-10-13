<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $fillable = ['time_in', 'time_out', 'employee_id'];

    public function employee(){
        return $this->belongsTo('App\Employee');
    }
}
