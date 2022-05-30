<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('desc')->nullable();
            $table->boolean('active')->default(0)->nullable();
            $table->string('slug');
            $table->boolean('show_menu')->default(0)->nullable();
            $table->string('template')->nullable();
            $table->timestamps();
        });
    }
}
