<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    protected $fillable = ['name', 'month_term', 'fixed_amount'];
}
