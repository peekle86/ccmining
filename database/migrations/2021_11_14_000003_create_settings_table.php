<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('settings');
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('price_kwt', 15, 2);
            $table->float('price_mh', 15, 4);
            $table->float('price_gh', 15, 4);
            $table->float('price_mh_ltc', 15, 4);
            $table->float('ref', 5, 2)->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
