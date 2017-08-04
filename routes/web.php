<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', 'HomeController@index')->name('totem.dashboard');
Route::get('{view}', 'HomeController@index')->where('view', '(.*)');

Route::group(['prefix' => 'schedule'], function () {
    Route::get('create', 'ScheduleController@create')->name('totem.schedule.create');
    Route::post('create', 'ScheduleController@store')->name('totem.schedule.create');
});
