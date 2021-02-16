<?php

use App\Group;
use App\KPI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Target;
use App\Task;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/kpi/tasks/{id}', 'TaskController@showTasks');
Route::resource('targets', 'TargetController');

// TASKS ROUTES
Route::get('/tasks/upload', 'TaskController@showUploadTaskForm')->name('tasks.upload');
Route::post('/tasks/upload', 'TaskController@storeUploadTask')->name('tasks.storeUpload');
Route::get('/tasks', 'TaskController@index')->name('tasks.index');
Route::post('/tasks', 'TaskController@store')->name('tasks.store');
Route::get('tasks/create', 'TaskController@create')->name('tasks.create');
Route::delete('tasks/{task}', 'TaskController@destroy')->name('tasks.destroy');
Route::put('tasks/{task}', 'TaskController@update')->name('tasks.update');
Route::get('tasks/{task}', 'TaskController@show')->name('tasks.show');
Route::get('tasks/{task}/edit', 'TaskController@edit')->name('tasks.edit');
Route::get('tasks/template/file', 'TaskController@getTemplate')->name('get_Template');

Route::resource('kpi', 'KPIController');
// report routes
Route::resource('reports', 'ReportController');
// query reports route
Route::get('/reports/query/report', 'ReportController@getQuery')->name('get_query');
// get query route
Route::post('/reports/task/Query', 'ReportController@getTaskQuery')->name('get_task_query');

Route::get('/get/kpi/groups/{group_id}', 'KPIController@getGroups')->name('getGroups');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');
    // division routes
    Route::resource('divisions', 'DivisionController');
    // group routes
    Route::resource('groups', 'GroupController');

});

// // kpi tasks
Route::get('kpi/tasks/{id}', 'KPIController@getTasks')->name('kpiTasks');
Route::post('/tasks/pdf', 'ReportController@createPDF')->name('create_pdf');

// get all kpis route
Route::get('/all/kpis', 'KPIController@getAllKpis')->name('allKpis');
