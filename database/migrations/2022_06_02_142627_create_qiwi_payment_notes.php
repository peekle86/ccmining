<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQiwiPaymentNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qiwi_payment_notes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->comment('Id покупця');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('qiwi_link_id')->comment('Id Qiwi лінку');

            $table->unsignedBigInteger('payment_system_id')->comment('id платіжної системи');
            $table->foreign('payment_system_id')->references('id')->on('payment_systems')->onUpdate('cascade')->onDelete('cascade');

            $table->string('payment_note')->comment('Платіжні записки');

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
        Schema::dropIfExists('qiwi_payment_notes');
    }
}
