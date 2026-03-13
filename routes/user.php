<?php

Route::group([
    'prefix' => 'user',
    'middleware' => ['auth', 'role:user']
], function () {

    Route::get('/home', [
        'as'   => 'user.home',
        'uses' => 'HomeController@index'
    ]);

    Route::get('/home/datatable', [
        'as'   => 'user.home.datatable',
        'uses' => 'HomeController@datatable'
    ]);

    Route::get('/home/books/detail/{id}', [
        'as' => 'user.books.detail',
        'uses' => 'HomeController@detail'
    ]);

    Route::post('/home/loans/store', [
        'as' => 'user.loans.store',
        'uses' => 'HomeController@storeLoan'
    ]);
});
