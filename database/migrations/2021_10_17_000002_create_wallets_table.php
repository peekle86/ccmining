<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('wallets');
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('address')->unique();
            $table->string('amount')->nullable();
            $table->timestamps();
        });
    }
}
