<?php

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth']
], function () {

    // DASHBOARD
    Route::get('dashboard', [
        'as'   => 'admin.dashboard',
        'uses' => 'Admin\DashboardController@index'
    ]);

    Route::get('dashboard/data', [
        'as'   => 'admin.dashboard.data',
        'uses' => 'Admin\DashboardController@datatable'
    ]);

    // KELOLA BUKU
    Route::get('books', [
        'as'   => 'admin.books.index',
        'uses' => 'Admin\BukuController@index'
    ]);

    Route::get('books/data', [
        'as'   => 'admin.books.datatable',
        'uses' => 'Admin\BukuController@datatable'
    ]);

    Route::post('books/store', [
        'as'   => 'admin.books.store',
        'uses' => 'Admin\BukuController@store'
    ]);

    // Pastikan urutan show (ID) berada di bawah agar tidak bentrok dengan rute statis
    Route::get('books/{id}', [
        'as'   => 'admin.books.show',
        'uses' => 'Admin\BukuController@show'
    ]);

    Route::post('books/update/{id}', [
        'as'   => 'admin.books.update',
        'uses' => 'Admin\BukuController@update'
    ]);

    Route::delete('books/delete/{id}', [
        'as'   => 'admin.books.delete',
        'uses' => 'Admin\BukuController@destroy'
    ]);
});
