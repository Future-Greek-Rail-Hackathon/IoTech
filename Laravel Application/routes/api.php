<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Sensor Type
    Route::apiResource('sensor-types', 'SensorTypeApiController');

    // Thing
    Route::apiResource('things', 'ThingApiController');

    // Points
    Route::post('points/media', 'PointsApiController@storeMedia')->name('points.storeMedia');
    Route::apiResource('points', 'PointsApiController');

    // Region
    Route::apiResource('regions', 'RegionApiController');

    // Maintenance Event Type
    Route::apiResource('maintenance-event-types', 'MaintenanceEventTypeApiController');

    // Maintenance Event
    Route::post('maintenance-events/media', 'MaintenanceEventApiController@storeMedia')->name('maintenance-events.storeMedia');
    Route::apiResource('maintenance-events', 'MaintenanceEventApiController');
});
