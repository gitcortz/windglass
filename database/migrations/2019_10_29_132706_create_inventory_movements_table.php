<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('stock_id')->unsigned();  
            $table->foreign('stock_id')->references('id')->on('inventory_stocks');
            $table->biginteger('user_id')->nullable()->unsigned();  
            $table->foreign('user_id')->references('id')->on('users'); 
            $table->integer('before');
            $table->integer('after');
            $table->string('reason_type');
            $table->string('reason');
            $table->biginteger('from_stock_id')->nullable()->unsigned();  
            $table->foreign('from_stock_id')->references('id')->on('inventory_stocks'); 
            $table->biginteger('order_item_id')->nullable()->unsigned();  
            $table->foreign('order_item_id')->references('id')->on('order_items'); 
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
        Schema::dropIfExists('inventory_movements');
    }
}
