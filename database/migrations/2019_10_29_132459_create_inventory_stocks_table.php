<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('store_id')->unsigned();  
            $table->foreign('store_id')->references('id')->on('stores');
            $table->biginteger('product_id')->unsigned();  
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('initial_stock');
            $table->integer('current_stock');
            $table->biginteger('stock_status_id')->unsigned();  
            $table->foreign('stock_status_id')->references('id')->on('stock_statuses');
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
        Schema::dropIfExists('inventory_stocks');
    }
}
