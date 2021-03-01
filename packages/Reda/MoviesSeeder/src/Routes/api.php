<?php
Route::group(['prefix' => 'api'], function ($router) {
    Route::group(['namespace' => 'Reda\MoviesSeeder\Http\Controllers\API'], function ($router) {
        Route::get('movies', 'MoviesController@index')->name('api.movies.index');
    });
});
