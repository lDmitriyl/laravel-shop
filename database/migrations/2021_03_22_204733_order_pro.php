<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderPro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_pro', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->integer('pro_id');
            $table->integer('count');
            $table->double('price');
            $table->timestamps();
        });
        Schema::dropIfExists('order_product');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('count');
            $table->double('price');
            $table->timestamps();
        });
        Schema::dropIfExists('order_pro');
    }
}
