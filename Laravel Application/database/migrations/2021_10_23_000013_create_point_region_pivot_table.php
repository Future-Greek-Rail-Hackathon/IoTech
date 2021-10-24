<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointRegionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('point_region', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id', 'region_id_fk_5183439')->references('id')->on('regions')->onDelete('cascade');
            $table->unsignedBigInteger('point_id');
            $table->foreign('point_id', 'point_id_fk_5183439')->references('id')->on('points')->onDelete('cascade');
        });
    }
}
