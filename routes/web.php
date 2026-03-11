<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Joko;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/insert-joko', function () {

    Joko::create([
        'name' => 'Joko Widodo',
        'asal_kota' => 'Surakarta',
        'asal_kabupaten' => 'Sragen'
    ]);

    return Joko::all();
});

Route::get('/testmodel', function () {
    // $query = /* isi sample query */ ;
    $query = DB::table('jokos')
        ->select('id', 'name', 'asal_kota', 'asal_kabupaten')
        ->get();
    return $query;
});

Auth::routes();

Route::get('/home', 'HomeController@index');
