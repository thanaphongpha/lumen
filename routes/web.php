<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//$router->get('/profile[/{name}]', function($profileId = null){
//   return 'My profile'. $profileId;
//});

$router->get('/people', 'ProfileController@index');
$router->get('/peoplesearch', 'ProfileController@search');
$router->put('/people', 'ProfileController@store');
$router->put('/peopleupdate/{id}', 'ProfileController@update');
$router->delete('/people/{id}', 'ProfileController@destroy');
//$router->get('/trainee', 'traineeController@index');

$router->group(['prefix' => 'trainee'], function () use ($router) {
    $router->get('/', 'TraineeController@index');
    $router->post('/', 'TraineeController@store');
});

$router->group(['prefix' => 'teacher'], function () use ($router) {
    $router->get('/', 'TeacherController@index');
    $router->post('/', 'TeacherController@store');
    $router->put('/{id}','TeacherController@update');
    $router->delete('/{id}','TeacherController@destroy');
});

$router->get('/users', 'SocialUserController@index');

$router->get('/feed', 'NewsFeedController@index');
$router->post('/feed', 'NewsFeedController@store');
$router->put('/feed/{id}', 'NewsFeedController@update');
$router->put('/feed/{id}/like', 'NewsFeedController@updateLike');
$router->delete('/feed/{id}', 'NewsFeedController@destroy');





$router->get('/checkIn', 'TimeAttendence@index');
$router->get('/checkInpagination', 'TimeAttendence@checkInPagination');
$router->get('/history', 'TimeAttendence@timeattendenthistorypanigationfortimeline');
$router->get('/leavetimeline', 'TimeAttendence@leavedatapanigationfortimeline');
$router->get('/leavequota', 'TimeAttendence@leavequota');
$router->get('/leavedataedit', 'TimeAttendence@leaveloadedit');

$router->get('/holiday', 'TimeAttendence@holiday');
$router->get('/id', 'TimeAttendence@id');
$router->get('/leavedataperson', 'TimeAttendence@leaveDataPerson');
$router->get('/leavedatapersonpagination', 'TimeAttendence@leaveDataPersonPagnigation');
$router->get('/historydata', 'TimeAttendence@historyData');
$router->get('/leavedatadepartment', 'TimeAttendence@leaveDataDepartment');
$router->get('/workholiday', 'TimeAttendence@workholiday');
$router->get('/workfromhome', 'TimeAttendence@workfromhome');

$router->post('/test', 'TimeAttendence@test');
$router->post('/leavedata', 'TimeAttendence@store_leave');
$router->post('/workholiday', 'TimeAttendence@store_workholiday');
$router->post('/workfromhome', 'TimeAttendence@store_workfromhome');
$router->post('/checkIn', 'TimeAttendence@store_in');
$router->post('/user','TimeAttendence@checkuser');
$router->post('/postphotourl','TimeAttendence@postphotourl');

$router->put('/leavedata', 'TimeAttendence@store_leave_edit');
$router->put('/checkOut/{id}', 'TimeAttendence@store_out');

$router->delete('/leavedata/{id}', 'TimeAttendence@destroy');
