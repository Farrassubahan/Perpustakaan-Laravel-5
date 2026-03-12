<?php

Route::group([
    'prefix' => 'user',
    'middleware' => ['auth','role:user']
], function () {

    Route::get('/home', [
        'as' => 'user.home',
        'uses' => 'HomeController@index'
    ]);
});
