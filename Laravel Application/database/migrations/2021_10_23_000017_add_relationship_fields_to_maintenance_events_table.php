<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMaintenanceEventsTable extends Migration
{
    public function up()
    {
        Schema::table('maintenance_events', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id', 'type_fk_5183767')->references('id')->on('maintenance_event_types');
            $table->unsignedBigInteger('poi_id')->nullable();
            $table->foreign('poi_id', 'poi_fk_5183768')->references('id')->on('points');
            $table->unsignedBigInteger('assigned_to_id')->nullable();
            $table->foreign('assigned_to_id', 'assigned_to_fk_5183775')->references('id')->on('users');
        });
    }
}
