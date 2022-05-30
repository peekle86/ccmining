<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBalancesTable extends Migration
{
    public function up()
    {
        Schema::table('balances', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_5155510')->references('id')->on('users');
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id', 'currency_fk_5155511')->references('id')->on('currencies');
        });
    }
}
