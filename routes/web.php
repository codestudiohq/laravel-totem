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
});
