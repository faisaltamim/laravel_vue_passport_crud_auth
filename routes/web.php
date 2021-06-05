<?php

use Illuminate\Support\Facades\Route;

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

Route::get( '/', function () {
    return view( 'master' );
} );

//this code for solve conflict vue router
Route::get( '/{vue_capture?}', function () {
    return view( 'master' );
} )->where( 'vue_capture', '[\/\w\.-]*' );
