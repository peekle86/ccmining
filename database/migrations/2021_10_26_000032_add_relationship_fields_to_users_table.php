<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id', 'parent_fk_5156859')->references('id')->on('users');
            $table->unsignedBigInteger('wallet_id')->nullable();
            $table->foreign('wallet_id', 'wallet_fk_5204098')->references('id')->on('wallets');
        });
    }
}
