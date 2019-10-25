<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->biginteger('order_status_id')->nullable()->unsigned();  
            $table->foreign('order_status_id')->references('id')->on('order_statuses');

            $table->biginteger('payment_method_id')->nullable()->unsigned();  
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
        
            $table->biginteger('payment_status_id')->nullable()->unsigned();  
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
