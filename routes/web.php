<?php

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/kpi/tasks/{id}', function ($id) {
    $target = Task::where('description', $id)
    ->where('responsible', Auth::user()->staff_no)->get();
    return response()->json($target, 200);
});
Route::resource( 'targets', 'TargetController');
Route::resource('tasks', 'TaskController');