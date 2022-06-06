<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->comment('Id покупця');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('order_id')->nullable()->comment('Id замовлення');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('wallet_id')->comment('Id адреси гаманця');
            $table->foreign('wallet_id')->references('id')->on('crypto_addresses')->onUpdate('cascade')->onDelete('cascade');

            $table->text('transaction_hash')->comment('Хеш транзакції');
            $table->float('amount')->comment('Сума транзакції');

            $table->enum('status', ['confirmed', 'unconfirmed'])->after('amount');
            $table->enum('crypto_type', ['usdt', 'btc'])->after('status');

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
        Schema::dropIfExists('crypto_transactions');
    }
}
