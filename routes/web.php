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
// change password route
Route::get('/changePassword', 'HomeController@showChangePasswordForm')->name('change-password');
Route::post('/changePassword', 'HomeController@changePassword')->name('changePassword');

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
// close task
Route::get('/tasks/close/{id}', 'TaskController@closeTask')->name('close_task');

Route::resource('kpi', 'KPIController');
// report routes
Route::resource('reports', 'ReportController');
// query reports route
Route::get('/reports/query/report', 'ReportController@getQuery')->name('get_query');
// get query route
Route::post('/reports/task/Query', 'ReportController@getTaskQuery')->name('get_task_query');

Route::get('/get/kpi/sections/{section_id}', 'KPIController@getGroups')->name('getGroups');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');
    // division routes
    Route::resource('divisions', 'DivisionController');
    // group routes
    Route::resource('sections', 'SectionController');
    // subsection routes
    Route::resource('subsections', 'SubSectionController');
    // department route
    Route::resource('department', 'DepartmentController');
});

// // kpi tasks
Route::get('kpi/tasks/{id}', 'KPIController@getTasks')->name('kpiTasks');
Route::post('/tasks/pdf', 'ReportController@createPDF')->name('create_pdf');

// get all kpis route
Route::get('/all/kpis', 'KPIController@getAllKpis')->name('allKpis');
// lava charts
Route::get('task_chart', 'ChartController@taskChart')->name('task_chart');
// manage structures
Route::get('manage/{structure}/{structure_id}/{manager_type}', 'ManageStructuresController@manageStructure')->name('manage_structure');
Route::post('manage/manager', 'ManageStructuresController@saveManager')->name('saveManager');
