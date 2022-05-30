<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url')->nullable()->unique();
            $table->string('title')->nullable();
            $table->longText('page_text')->nullable();
            $table->longText('excerpt')->nullable();
            $table->integer('language_id')->nullable();
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
        Schema::dropIfExists('content_pages');
    }
}
