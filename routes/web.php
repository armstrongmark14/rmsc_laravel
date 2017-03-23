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


// Naming this route home so that we can use it as a link on other pages easily
Route::get('/', array('as' => 'home', 'uses' => 'Volunteer\LoginController@loginPage'));


/*
 *
 *
 * Routes for the volunteer side of the site
 *
 */
// Grouping these together so that if user tries to access page without submitting form it redirects
Route::any('/volunteer/login', 'Volunteer\LoginController@loginCheck');

// Route for login failures
Route::get('/volunteer/login/failure/{id}', 'Volunteer\LoginController@loginFailure');

// Route for the volunteer profile directly after loggign in
Route::get('/volunteer/profile', 'Volunteer\VolunteerController@profile');

// Route for each specific volunteer to view their own timesheets
Route::get('/volunteer/timesheets', array('as' => 'volunteer-timesheets', 'uses' => 'Volunteer\VolunteerController@viewTimesheets'));


// Routes for the timeclock functionality
Route::get('/volunteer/timeclock/in', array('as' => 'clock-in', 'uses' => 'Volunteer\TimesheetController@clockIn'));
Route::get('/volunteer/timeclock/out', array('as' => 'clock-out', 'uses' => 'Volunteer\TimesheetController@clockOut'));

