<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToContractsTable extends Migration
{
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_5155628')->references('id')->on('users');
            $table->unsignedBigInteger('hardware_id');
            $table->foreign('hardware_id', 'hardware_fk_5155629')->references('id')->on('hardware_items');
            $table->unsignedBigInteger('period_id');
            $table->foreign('period_id', 'period_fk_5156020')->references('id')->on('contract_periods');
        });
    }
}
