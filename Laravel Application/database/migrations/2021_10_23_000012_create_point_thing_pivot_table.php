<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointThingPivotTable extends Migration
{
    public function up()
    {
        Schema::create('point_thing', function (Blueprint $table) {
            $table->unsignedBigInteger('point_id');
            $table->foreign('point_id', 'point_id_fk_5183412')->references('id')->on('points')->onDelete('cascade');
            $table->unsignedBigInteger('thing_id');
            $table->foreign('thing_id', 'thing_id_fk_5183412')->references('id')->on('things')->onDelete('cascade');
        });
    }
}
