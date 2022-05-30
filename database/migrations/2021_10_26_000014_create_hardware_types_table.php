<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareTypesTable extends Migration
{
    public function up()
    {
        Schema::create('hardware_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('symbol')->nullable();
            $table->string('algoritm')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
