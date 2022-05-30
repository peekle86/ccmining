<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
class CreateReviewsTable extends Migration
{
  public function up()
  {
    Schema::create('reviews', function(Blueprint $table) {
      $table->bigIncrements('id');
      $table->text('text');
      $table->string('lang_id');
      $table->string('name');

      $table->integer('sort');

      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('reviews');
  }
}