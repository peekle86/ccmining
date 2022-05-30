<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStatisticsTable extends Migration
{
    public function up()
    {
        Schema::create('user_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
