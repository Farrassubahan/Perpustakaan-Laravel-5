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

    // eksport data buku 
    Route::get('buku/export/excel', [
        'as'   => 'admin.buku.export.excel',
        'uses' => 'Admin\BukuController@exportExcel'
    ]);

    Route::get('buku/export/pdf', [
        'as'   => 'admin.buku.export.pdf',
        'uses' => 'Admin\BukuController@exportPdf'
    ]);


    // Tambahkan ini di dalam group admin
    Route::get('categories', ['as' => 'admin.categories.index', 'uses' => 'Admin\CategoryController@index']);

    Route::get('categories/data', ['as' => 'admin.categories.datatable', 'uses' => 'Admin\CategoryController@datatable']);

    Route::post('categories/store', ['as' => 'admin.categories.store', 'uses' => 'Admin\CategoryController@store']);

    Route::get('categories/{id}', ['as' => 'admin.categories.show', 'uses' => 'Admin\CategoryController@show']);

    Route::post('categories/update/{id}', ['as' => 'admin.categories.update', 'uses' => 'Admin\CategoryController@update']);

    Route::delete('categories/delete/{id}', ['as' => 'admin.categories.delete', 'uses' => 'Admin\CategoryController@destroy']);

    // KELOLA USER
    Route::get('users', [
        'as'   => 'admin.users.index',
        'uses' => 'Admin\UserController@index'
    ]);

    Route::get('users/data', [
        'as'   => 'admin.users.data-user',
        'uses' => 'Admin\UserController@datatable'
    ]);

    Route::get('users/create', [
        'as'   => 'admin.users.create',
        'uses' => 'Admin\UserController@create'
    ]);

    Route::post('users/store', [
        'as'   => 'admin.users.store',
        'uses' => 'Admin\UserController@store'
    ]);

    Route::get('users/{id}/edit', [
        'as'   => 'admin.users.edit',
        'uses' => 'Admin\UserController@edit'
    ]);

    Route::post('users/{id}/update', [
        'as'   => 'admin.users.update',
        'uses' => 'Admin\UserController@update'
    ]);

    Route::delete('users/{id}', [
        'as'   => 'admin.users.destroy',
        'uses' => 'Admin\UserController@destroy'
    ]);
   
   
    Route::get('/dashboard/chart-data', [
        'as'   => 'admin.dashboard.chart-data',
        'uses' => 'Admin\DashboardController@chartData'
    ]);


});
