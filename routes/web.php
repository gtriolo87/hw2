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

/* ROUTE DI ESEMPIO
Route::get('/', function () {
    return view('index');
});*/

/* ROUTE di ACCESSO */
Route::get('/', 'App\Http\Controllers\HomeController@index')->name("index");
Route::get('/test', 'App\Http\Controllers\UserController@test');

/* ROUTE per LIKE */
Route::get('/like/{jobId}', 'App\Http\Controllers\LikeController@countJobLike');
Route::get('/like/{jobId}/{userId}', 'App\Http\Controllers\LikeController@checkUserJobLike');
Route::get('/addLike/{jobId}/{userId}', 'App\Http\Controllers\LikeController@addLike');

/* ROUTE per USER */
Route::get('/user', 'App\Http\Controllers\UserController@index')->name("account");
Route::post('/user/login', 'App\Http\Controllers\UserController@login')->name("login");
Route::post('/user/signup', 'App\Http\Controllers\UserController@signup')->name("signup");
Route::get('/user/logout', 'App\Http\Controllers\UserController@logout')->name("logout");
Route::get('/user/checkUsername/{username}', 'App\Http\Controllers\UserController@checkUsername');
Route::get('/user/getUsers', 'App\Http\Controllers\UserController@getUsers');
Route::get('/user/getUsers/{groupId}', 'App\Http\Controllers\UserController@getUsersFiltered');
Route::get('/user/checkUsername/{username}', 'App\Http\Controllers\UserController@checkUsername')->name("checkUsername");
Route::get('/user/manageUser/{userId}', 'App\Http\Controllers\UserController@checkAdminPermission')->name("checkAdminPermission");
Route::get('/user/manageJob/{userId}', 'App\Http\Controllers\UserController@checkJobPermissions')->name("checkJobPermissions");
Route::get('/user/manageLike/{userId}', 'App\Http\Controllers\UserController@checkLikePermissions')->name("checkLikePermissions");
Route::get('/user/manageTask/{userId}', 'App\Http\Controllers\UserController@checkManageTaskPermissions')->name("checkManageTaskPermissions");
Route::get('/user/workTask/{userId}', 'App\Http\Controllers\UserController@checkWorkTaskPermissions')->name("checkWorkTaskPermissions");
Route::get('/user/editUserGroup/{userId}/{groupId}', 'App\Http\Controllers\UserController@editUserGroup');

/* ROUTE per JOB */
Route::get('/job', 'App\Http\Controllers\JobController@index')->name("job");
Route::get('/job/view/{jobId}', 'App\Http\Controllers\JobController@indexJob');
Route::post('/job/getJobs', 'App\Http\Controllers\JobController@getJobs')->name("getJobs");
Route::get('/job/getJob/{jobId}', 'App\Http\Controllers\JobController@getJob');
Route::post('/job/editJob', 'App\Http\Controllers\JobController@editJob');
Route::post('/job/addJob', 'App\Http\Controllers\JobController@addJob');
Route::post('/job/searchJob', 'App\Http\Controllers\JobController@searchJob')->name("searchJob");

/* ROUTE per GESTIONE UTENTI */
Route::get('/administration', 'App\Http\Controllers\AdminController@index')->name('administration');
Route::get('/administration/filter/{groupId}', 'App\Http\Controllers\AdminController@filterUsers')->name("filterUsers");

/* ROUTE per SERVIZI ESTERNI */
Route::get('/service/ToDo', 'App\Http\Controllers\ExternalController@getToDo')->name("getToDo");
Route::get('/service/videos/{keywords}', 'App\Http\Controllers\ExternalController@getVideos')->name("getVideos");