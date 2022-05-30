<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserStatisticsTable extends Migration
{
    public function up()
    {
        Schema::table('user_statistics', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_5156278')->references('id')->on('users');
        });
    }
}
