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
            $table->biginteger('customer_id')->unsigned();  
            $table->foreign('customer_id')->references('id')->on('customers'); 

            $table->biginteger('pos_session_id')->nullable()->unsigned();  
            $table->foreign('pos_session_id')->references('id')->on('pos_sessions');  

            $table->biginteger('store_id')->nullable()->unsigned();  
            $table->foreign('store_id')->references('id')->on('stores');

            $table->biginteger('rider_id')->nullable()->unsigned();  
            $table->foreign('rider_id')->references('id')->on('employees');
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
