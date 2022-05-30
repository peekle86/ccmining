<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPercentAndPeriodToCartHardwareItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_hardware_item', function (Blueprint $table) {
            $table->float('percent', 5, 2)->nullable();
            $table->foreignId('period_id')->nullable()->references('id')
            ->on('contract_periods')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_hardware_item', function (Blueprint $table) {
            $table->dropColumn('percent');
            $table->dropColumn('period_id');
        });
    }
}
