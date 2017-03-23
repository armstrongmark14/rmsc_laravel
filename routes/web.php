<?php

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

use App\Http\Controllers\Volunteer\LoginController;


// Naming this route home so that we can use it as a link on other pages easily
Route::get('/', array('as' => 'home', 'uses' => 'LoginController@loginPage'));

// Grouping these together so that if user tries to access page without submitting form it redirects
Route::any('/volunteer', 'LoginController@volunteer')->middleware('volunteer');




