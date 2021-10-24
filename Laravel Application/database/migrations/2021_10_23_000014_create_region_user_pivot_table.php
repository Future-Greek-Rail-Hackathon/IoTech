<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('region_user', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id', 'region_id_fk_5183440')->references('id')->on('regions')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5183440')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
