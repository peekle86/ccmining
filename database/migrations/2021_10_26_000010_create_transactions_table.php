<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('amount');
            $table->string('status');
            $table->string('source')->nullable();
            $table->string('target')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
