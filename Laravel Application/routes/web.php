<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Sensor Type
    Route::delete('sensor-types/destroy', 'SensorTypeController@massDestroy')->name('sensor-types.massDestroy');
    Route::resource('sensor-types', 'SensorTypeController');

    // Thing
    Route::delete('things/destroy', 'ThingController@massDestroy')->name('things.massDestroy');
    Route::resource('things', 'ThingController');

    // Points
    Route::delete('points/destroy', 'PointsController@massDestroy')->name('points.massDestroy');
    Route::post('points/media', 'PointsController@storeMedia')->name('points.storeMedia');
    Route::post('points/ckmedia', 'PointsController@storeCKEditorImages')->name('points.storeCKEditorImages');
    Route::resource('points', 'PointsController');

    // Region
    Route::delete('regions/destroy', 'RegionController@massDestroy')->name('regions.massDestroy');
    Route::resource('regions', 'RegionController');

    // Maintenance Event Type
    Route::delete('maintenance-event-types/destroy', 'MaintenanceEventTypeController@massDestroy')->name('maintenance-event-types.massDestroy');
    Route::resource('maintenance-event-types', 'MaintenanceEventTypeController');

    // Maintenance Event
    Route::delete('maintenance-events/destroy', 'MaintenanceEventController@massDestroy')->name('maintenance-events.massDestroy');
    Route::post('maintenance-events/media', 'MaintenanceEventController@storeMedia')->name('maintenance-events.storeMedia');
    Route::post('maintenance-events/ckmedia', 'MaintenanceEventController@storeCKEditorImages')->name('maintenance-events.storeCKEditorImages');
    Route::resource('maintenance-events', 'MaintenanceEventController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
