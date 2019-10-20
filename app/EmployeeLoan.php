<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeLoan extends Model
{
    protected $fillable = ['loan_amount', 'status', 'employee_id', 'loan_type_id'];
    
    public function loanType(){
        return $this->belongsTo('App\LoanType');
    }
}
