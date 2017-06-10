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
Route::group(['middleware' => 'prevent-back-button'], function() {


    // Route for the volunteer profile directly after loggign in
    Route::get('/volunteer/profile', array('as' => 'volunteer-page', 'uses' => 'Volunteer\VolunteerController@profile'));

    // Route for each specific volunteer to view their own timesheets
    Route::get('/volunteer/timesheets', array('as' => 'volunteer-timesheets', 'uses' => 'Volunteer\VolunteerController@viewTimesheets'));

    // Routes for the timeclock functionality
    Route::get('/volunteer/timeclock/in', array('as' => 'clock-in', 'uses' => 'Volunteer\TimesheetController@clockIn'));
    Route::get('/volunteer/timeclock/out', array('as' => 'clock-out', 'uses' => 'Volunteer\TimesheetController@clockOut'));
    // Routes for editing timesheets as a volunteer
    Route::get('/volunteer/timeclock/edit-timesheet/{id}', array('as' => 'volunteer-edit-timesheet', 'uses' => 'Volunteer\TimesheetController@edit'));
    Route::post('/volunteer/timeclock/update-timesheet', array('as' => 'volunteer-update-timesheet', 'uses' => 'Volunteer\TimesheetController@updateTimesheet'));
    // Routes for creating timesheets from scratch as a volunteer
    Route::get('/volunteer/timeclock/create-timesheet', array('as' => 'volunteer-create-timesheet', 'uses' => 'Volunteer\TimesheetController@createTimesheetPage'));
    Route::post('/volunteer/timeclock/create-timesheet/new', array('as' => 'volunteer-create-timesheet-new', 'uses' => 'Volunteer\TimesheetController@createTimesheet'));



    // Route for entering a new badge and creating an entry
    Route::get('admin/volunteer/add-new', ['as' => 'new-badge', 'uses' => 'Admin\AdminController@newBadgeSwiped']);
    // This route will just be for redirecting someone trying to access the new-volunteer-swipe page unofficially
    Route::get('admin/volunteer/add-volunteer', ['as' => 'reject-add-swipe', 'uses' => 'Admin\AdminController@rejectAddSwipe']);
    Route::post('admin/volunteer/add-volunteer', ['as' => 'new-volunteer-swipe', 'uses' => 'Admin\AdminController@newBadge']);
    Route::post('admin/volunteer/add-new/submitted', ['as' => 'new-badge-submitted', 'uses' => 'Admin\AdminController@newBadgeSubmitted']);


    // ROUTES FOR THE ADMIN SECTIONS OF THE SITE
    //

    // Admin login page
    Route::get('/admin', array('as' => 'admin-login', 'uses' => 'Admin\LoginController@loginPage'));

    // Grouping these together so that if user tries to access page without submitting form it redirects
    Route::any('/admin/login', 'Admin\LoginController@loginCheck');


    Route::group(['middleware' => 'admin-login-middleware', 'namespace' => 'Admin'], function() {

        // Admin homepage
        Route::get('/admin/home', array('as' => 'admin-home', 'uses' => 'AdminController@homepage'));

        // Full volunteer List
        Route::get('/admin/volunteer-list', array('as' => 'admin-volunteer-list', 'uses' => 'AdminController@fullVolunteerList'));

        // Currently Here volunteer list
        Route::get('/admin/volunteers-here', ['as' => 'volunteers-here' , 'uses' => 'AdminController@currentlyHere']);
        // Showing all of the currently open timesheets
        Route::get('admin/time/open-timesheets', ['as' => 'open-timesheets', 'uses' => 'AdminController@openTimesheets']);

        // Updating and creating volunteer records
        Route::get('admin/volunteer/add', ['as' => 'admin-create-volunteer', 'uses' => 'AdminController@addVolunteer']);
        Route::post('admin/volunteer/update', 'AdminController@updateVolunteer');
        Route::post('admin/volunteer/create', 'AdminController@createVolunteer');


        // Showing a single volunteer profile
        Route::get('admin/volunteer/{id}/profile', ['as' => 'volunteer-profile', 'uses' => 'AdminController@volunteerProfile']);
        Route::get('admin/volunteer/{id}/timesheet', ['as' => 'admin-volunteer-timesheet', 'uses' => 'AdminController@volunteerTimesheet']);
        // Routes for editing timesheets
        Route::get('admin/edit/timesheet/{id}', ['as' => 'admin-edit-timesheet', 'uses' => 'AdminController@editTimesheet']);
        Route::post('admin/update/timesheet', ['as' => 'admin-update-timesheet', 'uses' => 'AdminController@updateTimesheet']);
        Route::get('admin/remove/timesheet/{id}', ['as' => 'admin-remove-timesheet', 'uses' => 'AdminController@removeTimesheet']);

        // Routes for charting charts
        Route::get('admin/charts/total-hours', ['as' => 'total-hours-chart', 'uses' => 'ChartController@totalHours']);

        // routes for loading the stuff on the homepage through AJAX
        Route::get('admin/homepage/current-count', 'ChartController@updateHomeVolunteerCount');
        Route::get('admin/homepage/todays-hours', 'ChartController@updateHomeHourCount');
        Route::get('admin/homepage/total-logins', 'ChartController@updateHomeTotalLogins');
        Route::get('admin/homepage/total-hours', 'ChartController@updateHomeTotalHours');



        /**
         * ROUTES FOR THE SUPER ADMINS
         */
        Route::group(['middleware' => 'super-admin-middleware'], function() {

            // For confirming deletion of a volunteer from the database
            Route::get('admin/super/volunteer/{id}/delete', ['as' => 'volunteer-delete', 'uses' => 'AdminController@volunteerDelete']);
            Route::get('admin/super/volunteer/{id}/delete/confirmed', ['as' => 'volunteer-delete-confirmed', 'uses' => 'AdminController@volunteerDeleteConfirmed']);

            // The super admin dashboard for adding types and stuff
            Route::get('admin/super/dashboard', ['as' => 'super-admin-dashboard' , 'uses' => 'SuperAdminController@dashboard']);
            // Routes for adding types and departments
            Route::post('admin/super/add/type', ['as' => 'add-type', 'uses' => 'SuperAdminController@addType']);
            Route::post('admin/super/add/department', ['as' => 'add-department', 'uses' => 'SuperAdminController@addDepartment']);
            Route::post('admin/super/add/location', ['as' => 'add-location', 'uses' => 'SuperAdminController@addLocation']);
            // Routes for removing types and departments
            Route::get('admin/super/remove/{id}/type', ['as' => 'remove-type', 'uses' => 'SuperAdminController@removeType']);
            Route::get('admin/super/remove/{id}/department', ['as' => 'remove-department', 'uses' => 'SuperAdminController@removeDepartment']);
            Route::get('admin/super/remove/{id}/location', ['as' => 'remove-location', 'uses' => 'SuperAdminController@removeLocation']);

            // Routes for managing RMSC Admin users
            Route::get('admin/super/users', ['as' => 'manage-users', 'uses' => 'SuperAdminController@manageUsers']);
            Route::get('admin/super/remove-user/{id}', ['as' => 'remove-admin-user', 'uses' => 'SuperAdminController@removeUser']);
            Route::get('admin/super/add-user', ['as' => 'admin-add-user', 'uses' => 'SuperAdminController@addUserPage']);
            Route::post('admin/super/add-user', ['as' => 'admin-add-user-submit', 'uses' => 'SuperAdminController@addUser']);

            // Routes for changing password
            Route::get('admin/change-password', ['as' => 'admin-change-password', 'uses' => 'AdminController@changePassword']);
            Route::post('admin/change-password', ['as' => 'admin-change-password', 'uses' => 'AdminController@updatePassword']);

            Route::post('admin/super/change-permissions', 'SuperAdminController@changePermissions');


        });


    }); // End of the admin routes


}); // End of the back button disabled routes

