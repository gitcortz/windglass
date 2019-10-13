<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = ['group', 'employee_id', 'start_date', 'end_date', 
    'work_days', 'rate', 'gross_salary', 'late_hours', 'overtime_hours',
    'overtime_pay', 'loan_pay', 'other_pay', 'net_pay'];

    public function employee(){
        return $this->belongsTo('App\Employee');
    }
}
