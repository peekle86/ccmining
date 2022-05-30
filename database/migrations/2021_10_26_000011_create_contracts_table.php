<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('amount', 15, 2);
            $table->datetime('ended_at')->nullable();
            $table->string('active');
            $table->float('percent', 5, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
