<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToWalletsTable extends Migration
{
    public function up()
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_5204100')->references('id')->on('users');
            $table->unsignedBigInteger('network_id');
            $table->foreign('network_id', 'network_fk_5609974')->references('id')->on('wallet_networks');
        });
    }
}
