<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
class AddEmailsToSettings extends Migration
{
  public function up()
  {
    Schema::table('settings', function(Blueprint $table) {
      $table->string('email_ru')->nullable();
      $table->string('email_en')->nullable();
      $table->string('email_es')->nullable();
    });
  }

  public function down()
  {
    Schema::table('settings', function(Blueprint $table) {
      //
    });
  }
}