<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePosSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pos_sessions', function (Blueprint $table) {
            //$table->biginteger('user_id')->unsigned();  
            //$table->foreign('user_id')->references('id')->on('users');  

            $table->biginteger('store_id')->unsigned();  
            $table->foreign('store_id')->references('id')->on('stores');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pos_sessions', function (Blueprint $table) {
            //
        });
    }
}
