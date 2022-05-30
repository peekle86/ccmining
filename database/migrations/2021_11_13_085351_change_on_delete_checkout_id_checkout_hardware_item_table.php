<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOnDeleteCheckoutIdCheckoutHardwareItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('checkout_hardware_item');

        Schema::create('checkout_hardware_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checkout_id')->constrained()->onDelete('cascade');
            $table->foreignId('hardware_item_id')->constrained();
            $table->float('percent');
            $table->float('price');
            $table->foreignId('period_id')->constrained('contract_periods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
