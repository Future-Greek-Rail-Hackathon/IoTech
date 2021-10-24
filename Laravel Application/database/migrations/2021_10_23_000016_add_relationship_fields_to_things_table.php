<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToThingsTable extends Migration
{
    public function up()
    {
        Schema::table('things', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id', 'type_fk_5182982')->references('id')->on('sensor_types');
        });
    }
}
