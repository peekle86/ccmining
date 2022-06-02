<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQiwiLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qiwi_links', function (Blueprint $table) {
            $table->id();
            $table->string('nickname')->comment('Нікнейм');
            $table->string('login')->comment('Логін');
            $table->string('api_key')->comment('Ключ до Api');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qiwi_links');
    }
}
