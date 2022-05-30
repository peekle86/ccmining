<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_5155794')->references('id')->on('users');
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->foreign('contract_id', 'contract_fk_5155823')->references('id')->on('contracts');
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id', 'currency_fk_5155824')->references('id')->on('currencies');
        });
    }
}
