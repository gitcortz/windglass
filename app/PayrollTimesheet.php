<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayrollTimesheet extends Model
{
    protected $fillable = ['timesheet_date', 'employee_id', 'work_hours',
                 'overtime_hours', 'late_hours'];

    public function employee(){
        return $this->belongsTo('App\Employee');
    }
    
}
