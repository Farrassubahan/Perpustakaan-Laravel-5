<?php

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'role:admin']
], function () {

    // import excel
    Route::post('books/import', [
        'as'   => 'admin.books.import',
        'uses' => 'Admin\BukuController@import'
    ]);
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

    // Tambahkan ini di dalam group admin
    Route::get('categories', ['as' => 'admin.categories.index', 'uses' => 'Admin\CategoryController@index']);

    Route::get('categories/data', ['as' => 'admin.categories.datatable', 'uses' => 'Admin\CategoryController@datatable']);

    Route::post('categories/store', ['as' => 'admin.categories.store', 'uses' => 'Admin\CategoryController@store']);

    Route::get('categories/{id}', ['as' => 'admin.categories.show', 'uses' => 'Admin\CategoryController@show']);

    Route::post('categories/update/{id}', ['as' => 'admin.categories.update', 'uses' => 'Admin\CategoryController@update']);

    Route::delete('categories/delete/{id}', ['as' => 'admin.categories.delete', 'uses' => 'Admin\CategoryController@destroy']);
});
