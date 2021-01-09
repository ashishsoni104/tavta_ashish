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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/send-connection-request/{request_user_id}','HomeController@sendConnectRequest');
Route::get('/pending-request','HomeController@pendingRequest');
Route::get('/my-connection','HomeController@myConnection');
Route::get('/manage-status/{request_user_id}/{type}','HomeController@acceptRejectRequest');