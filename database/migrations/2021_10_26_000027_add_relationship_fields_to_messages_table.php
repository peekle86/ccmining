<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMessagesTable extends Migration
{
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('from_id');
            $table->foreign('from_id', 'from_fk_5156862')->references('id')->on('users');
            $table->unsignedBigInteger('to_id')->nullable();
            $table->foreign('to_id', 'to_fk_5156863')->references('id')->on('users');
            $table->unsignedBigInteger('chat_id');
            $table->foreign('chat_id', 'chat_fk_5202519')->references('id')->on('chats');
        });
    }
}
