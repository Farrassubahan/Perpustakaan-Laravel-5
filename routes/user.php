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

    // halaman buku yang dipinjam oleh user
    Route::get('/books/my-loans', [
        'as' => 'user.books.myloans',
        'uses' => 'BookController@myLoans'
    ]);

    Route::get('/books/my-loans/datatable', [
        'as' => 'user.books.myloans.datatable',
        'uses' => 'BookController@datatableMyLoans'
    ]);

    Route::post('/books/return/{id}', [
        'as' => 'user.books.return',
        'uses' => 'BookController@returnBook'
    ]);
});
