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
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('work_days');
            $table->decimal('daily_rate', 9, 2)->nullable(); 
            $table->decimal('gross_salary', 9, 2)->nullable();  
            $table->decimal('late_hours', 9, 2)->nullable();  
            $table->decimal('overtime_hours', 9, 2)->nullable();  
            $table->decimal('overtime_pay', 9, 2)->nullable();
            $table->decimal('loan_pay', 9, 2)->nullable();
            $table->decimal('other_pay', 9, 2)->nullable();
            $table->decimal('net_pay', 9, 2)->nullable();

            $table->biginteger('employee_id')->unsigned();  
            $table->foreign('employee_id')->references('id')->on('employees');

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
