<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group');
            $table->string('employee_id');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('work_days');
            $table->string('rate');
            $table->string('gross_salary');            
            $table->string('late_hours');
            $table->string('overtime_hours');
            $table->string('overtime_pay');
            $table->string('loan_pay');
            $table->string('other_pay');
            $table->string('net_pay');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}
