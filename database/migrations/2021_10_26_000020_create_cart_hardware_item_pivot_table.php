<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartHardwareItemPivotTable extends Migration
{
    public function up()
    {
        Schema::create('cart_hardware_item', function (Blueprint $table) {
            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id', 'cart_id_fk_5204029')->references('id')->on('carts')->onDelete('cascade');
            $table->unsignedBigInteger('hardware_item_id');
            $table->foreign('hardware_item_id', 'hardware_item_id_fk_5204029')->references('id')->on('hardware_items')->onDelete('cascade');
        });
    }
}
