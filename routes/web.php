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

    Route::get('{task}', 'TasksController@show')->name('totem.task.view');

    Route::get('{task}/edit', 'TasksController@edit')->name('totem.task.edit');
    Route::post('{task}/edit', 'TasksController@update');

});
