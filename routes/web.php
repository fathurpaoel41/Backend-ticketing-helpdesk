<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    echo "welcome";
});

$router->get('/version', function () use ($router) {
    return $router->app->version();
});

$router->get('/migrate', "ExampleController@migrate");

$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});

$router->get('/tes','ExampleController@tes');

//AUTH
Route::group([

    'prefix' => 'api/auth'

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

//User
Route::group([

    'prefix' => 'api/user'

], function ($router) {
    Route::post('filter-user','UserController@filterUser');
    Route::post('add-user', 'UserController@addUser');
    Route::get('get-all-user','UserController@getAllUser');
    Route::get('get-user/{id}','UserController@getUser');
    Route::put('edit-user/{id}','UserController@editUser');
    Route::delete('delete-user/{id}','UserController@deleteUser');
    Route::post('check-email', 'UserController@checkEmail');
    Route::post('search-user','UserController@search');
    Route::post('get-user-divisi','UserController@getUserDivisi');
});

Route::group([

    'prefix' => 'api/dashboard'

], function ($router) {
    // Route::get('get-all-ticket','DashboardController@readAllTicket');
    Route::get('category-chart','DashboardController@categoryChart');
    Route::get('get-ticket-without-done','DashboardController@getTicketWithoutDone');
});

Route::group([

    'prefix' => 'api/ticket'

], function ($router) {
    Route::get('read-ticket-it','TicketController@readTicketIT');
    Route::get('read-ticket/{idTicket}','TicketController@readTicket');
    Route::post('input-ticket','TicketController@inputTicket');
    Route::post('read-ticket-client','TicketController@readTicketIdClient');
    Route::post('search-ticket','TicketController@searchTicket');
    Route::post('approval-ticket','TicketController@approvalTicket');
    Route::get('get-ticket-in-progress','TicketController@getTicketInProgress');
    Route::post('done-ticket','TicketController@doneTicket');
});

Route::group([

    'prefix' => 'api/tracking'

], function ($router) {
    Route::get('read-all-tracking/{idTicket}','TrackingController@readAllTracking');
    Route::post('confirm-tracking-progress','TrackingController@confirmTrackingProgress');
});

Route::group([

    'prefix' => 'api/category'

], function ($router) {
    Route::get('get-all-category','categoryController@getAllCategory');
    Route::get('get-category/{idKategori}','categoryController@getCategory');
    Route::post('add-category','categoryController@addCategory');
    Route::put('update-category/{idCategory}','categoryController@updateCategory');
    Route::delete('delete-category/{idCategory}','categoryController@deleteCategory');
    Route::post('search-category','categoryController@searchCategory');
});

Route::group([

    'prefix' => 'api/divisi'

], function ($router) {
    Route::get('get-all-divisi-selected','divisiController@getAllDivisiSelected');
    Route::get('get-all-divisi','divisiController@getAllDivisi');
    Route::get('get-divisi/{idDivisi}','divisiController@getDivisi');
    Route::post('add-divisi','divisiController@addDivisi');
    Route::put('update-divisi/{idDivisi}','divisiController@updateDivisi');
    Route::delete('delete-divisi/{idDivisi}','divisiController@deleteDivisi');
    Route::post('search-divisi','divisiController@searchDivisi');
});

Route::group([

    'prefix' => 'api/feedback'

], function ($router) {
    Route::get('get-feedback/{idFeedback}','FeedbackController@getFeedback');
    Route::post('add-feedback','FeedbackController@addFeedback');
});