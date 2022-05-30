<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToHardwareItemsTable extends Migration
{
    public function up()
    {
        Schema::table('hardware_items', function (Blueprint $table) {
            $table->unsignedBigInteger('algoritm_id');
            $table->foreign('algoritm_id', 'algoritm_fk_5155595')->references('id')->on('hardware_types');
        });
    }
}
