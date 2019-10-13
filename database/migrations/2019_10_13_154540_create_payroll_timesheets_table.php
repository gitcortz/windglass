<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_timesheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('timesheet_date');
            $table->integer('work_hours');
            $table->integer('overtime_hours');
            $table->integer('late_hours');
            
            $table->biginteger('employee_id')->unsigned();  
            $table->foreign('employee_id')->references('id')->on('employees');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_timesheets');
    }
}
