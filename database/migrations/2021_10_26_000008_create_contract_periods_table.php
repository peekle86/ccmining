<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractPeriodsTable extends Migration
{
    public function up()
    {
        Schema::create('contract_periods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('period');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
