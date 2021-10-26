<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
// this routes use for the auth system start
Route::group( ['prefix' => 'auth'], function () {

    Route::post( 'register', 'Api\AuthController@register' );
    Route::post( 'login', 'Api\AuthController@login' );

    Route::group( ['middleware' => 'auth:api'], function () {
        Route::post( 'logout', 'Api\AuthController@logout' );

    } );

} );
// this routes use for the auth system end
Route::get( 'get-token', 'Api\AuthController@getToken' )->middleware( 'auth:api' );//


// this routes use for the category edit system start
Route::group( ['prefix' => 'user'], function () {
    Route::group( ['middleware' => 'auth:api'], function () {
        Route::post( 'edit-category', function () {
            $jsonData = [
                'message'        => 'Admin Access',
                'success_status' => true,
            ];
            return response()->json( $jsonData, 200 );
        } )->middleware( 'scope:do_anything' ); //mone rakhte hobe scope: ei colon er por space dile scope middleware ar kaaj korbe na

        Route::post( 'create-category', function () {
            $jsonData = [
                'message'        => 'Everyone Access',
                'success_status' => true,
            ];
            return response()->json( $jsonData, 200 );
        } )->middleware( 'scope:do_anything,can_create' ); //mone rakhte hobe scope: ei colon er por space dile scope middleware ar kaaj korbe na
    } );
} );
// this routes use for the category edit system end

// this routes use for the category start
Route::resource( 'category', 'Api\CategoryController' );

// below routes use for checkbox select action
Route::delete( 'category/delete-all/{selected}', 'Api\CategoryController@deleteAll' );
Route::put( 'category/active-all/{selected}', 'Api\CategoryController@activeAll' );
Route::put( 'category/inactive-all/{selected}', 'Api\CategoryController@inactiveAll' );
// this routes use for the category end