<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletNetworksTable extends Migration
{
    public function up()
    {
        Schema::create('wallet_networks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('symbol')->nullable();
            $table->string('in_usd')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
