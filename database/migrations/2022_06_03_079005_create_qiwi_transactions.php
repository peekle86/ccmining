<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQiwiTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qiwi_transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->comment('Id покупця');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('order_id')->nullable()->comment('Id замовлення');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('transaction_id')->comment('id Транзакції');

            $table->float('amount')->comment('Сума переказу');

            $table->enum('status', ['confirmed', 'unconfirmed']);

            $table->unsignedBigInteger('payment_system_id')->comment('id платіжної системи');
            $table->foreign('payment_system_id')->references('id')->on('payment_systems')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamp('created_date');

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
        Schema::dropIfExists('qiwi_transactions');
    }
}
