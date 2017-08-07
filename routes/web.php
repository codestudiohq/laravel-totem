<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', 'DashboardController@index')->name('totem.dashboard');

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', 'TasksController@index')->name('totem.tasks.all');

    Route::get('create', 'TasksController@create')->name('totem.task.create');
    Route::post('create', 'TasksController@store');

    Route::post('status', 'ActiveTasksController@store')->name('totem.task.activate');
    Route::delete('status/{id}', 'ActiveTasksController@destroy')->name('totem.task.deactivate');

    Route::get('{task}', 'TasksController@edit')->name('totem.task.update');
    Route::post('{task}', 'TasksController@update');

});
