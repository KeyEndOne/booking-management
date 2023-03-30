<?php

use App\Http\Controllers\admin\AdminController;
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

Route::get('/', ['as'=>'clienthome', 'uses'=>'ClientController@index']);
Route::get('about', ['as'=>'about', 'uses'=>'ClientController@about']);
Route::get('accessdenied', ['as'=>'accessdenied', 'uses'=>'ClientController@accessdenied']);
Route::get('search', ['as'=>'search', 'uses'=>'TicketController@searchtour']);
//client area
Route::get('ok', ['as'=>'ok', 'uses'=>'TicketController@ticketok'])->middleware('auth');
Route::post('createticket', ['as'=>'createticket', 'uses'=>'TicketController@createticket'])->middleware('auth');
Route::post('delticket', ['as'=>'delticket', 'uses'=>'TicketController@delticket'])->middleware('auth');
Route::get('searchtiket', ['as'=>'searchtiket', 'uses'=>'TicketController@searchtiket'])->middleware('auth');

//admin area
Route::get('/admin/dashboard', ['as'=>'/admin/dashboard', 'uses'=>'AdminController@home'])->middleware('auth')->middleware('admin');
Route::get('address', ['as'=>'address', 'uses'=>'AdminController@address'])->middleware('auth')->middleware('admin');

//address master data
Route::post('createaddress', ['as'=>'createaddress', 'uses'=>'AdminController@createaddress'])->middleware('auth')->middleware('admin');
Route::post('editaddress', ['as'=>'editaddress', 'uses'=>'AdminController@editaddress'])->middleware('auth')->middleware('admin');
Route::post('deladdress', ['as'=>'deladdress', 'uses'=>'AdminController@deladdress'])->middleware('auth')->middleware('admin');
Route::get('tour', ['as'=>'tour', 'uses'=>'AdminController@tour'])->middleware('auth')->middleware('admin');
Route::post('createtour', ['as'=>'createtour', 'uses'=>'AdminController@createtour'])->middleware('auth')->middleware('admin');
Route::post('edittour', ['as'=>'edittour', 'uses'=>'AdminController@edittour'])->middleware('auth')->middleware('admin');
Route::post('deltour', ['as'=>'deltour', 'uses'=>'AdminController@deltour'])->middleware('auth')->middleware('admin');
Route::get('user', ['as'=>'user', 'uses'=>'AdminController@user'])->middleware('auth')->middleware('admin');
Route::post('deluser', ['as'=>'deluser', 'uses'=>'AdminController@deluser'])->middleware('auth')->middleware('admin');


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
