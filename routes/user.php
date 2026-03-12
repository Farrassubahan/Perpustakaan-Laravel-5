<?php

Route::group([
    'prefix' => 'user',
    'middleware' => 'auth'
], function () {

    Route::get('/home', [
        'as' => 'user.home',
        'uses' => 'HomeController@index'
    ]);
});
