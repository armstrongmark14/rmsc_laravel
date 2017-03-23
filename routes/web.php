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

// Grouping these together so that if user tries to access page without submitting form it redirects
Route::any('/volunteer/login', 'Volunteer\LoginController@loginCheck');

// Route for login failures
Route::get('/volunteer/login/failure/{id}', 'Volunteer\LoginController@loginFailure');



// This groupf of middleware prevents the back button from being used to resend form data
Route::group(['middleware' => 'prevent-back-button', 'namespace' => 'Volunteer'], function() {
    // Route for the volunteer profile directly after loggign in
    Route::get('/volunteer/profile', 'VolunteerController@profile');

    // Route for each specific volunteer to view their own timesheets
    Route::get('/volunteer/timesheets', array('as' => 'volunteer-timesheets', 'uses' => 'VolunteerController@viewTimesheets'));

    // Routes for the timeclock functionality
    Route::get('/volunteer/timeclock/in', array('as' => 'clock-in', 'uses' => 'TimesheetController@clockIn'));
    Route::get('/volunteer/timeclock/out', array('as' => 'clock-out', 'uses' => 'TimesheetController@clockOut'));
});


// ROUTES FOR THE ADMIN SECTIONS OF THE SITE
// Admin login page
Route::get('/admin', array('as' => 'admin-login', 'uses' => 'Admin\LoginController@loginPage'));

// Grouping these together so that if user tries to access page without submitting form it redirects
Route::any('/admin/login', 'Admin\LoginController@loginCheck');

// Admin homepage
Route::get('/admin/home', array('as' => 'admin-home', 'uses' => 'Admin\AdminController@homepage'));

// Full volunteer List
Route::get('/admin/volunteer-list', array('as' => 'admin-volunteer-list', 'uses' => 'Admin\AdminController@fullVolunteerList'));

// Currently Here volunteer list
Route::get('/admin/volunteers-here', ['as' => 'volunteers-here' , 'uses' => 'Admin\AdminController@currentlyHere']);

Route::get('admin/volunteer/{id}/profile', ['as' => 'volunteer-profile', 'uses' => 'Admin\AdminController@volunteerProfile']);
