<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareItemsTable extends Migration
{
    public function up()
    {
        Schema::create('hardware_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model');
            $table->string('hashrate')->nullable();
            $table->string('power')->nullable();
            $table->string('profitability');
            $table->string('available')->nullable();
            $table->longText('description')->nullable();
            $table->longText('specification')->nullable();
            $table->longText('coins')->nullable();
            $table->longText('script')->nullable();
            $table->string('url')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
