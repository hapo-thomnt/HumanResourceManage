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

Route::get('/', function () {
    return view('auth.login');
});
Route::resources([
    'tasks' => 'TaskController',
    'companies' => 'CompanyController',
    'customers' => 'CustomerController',
    'reports' => 'ReportController',
    'employees' => 'EmployeeController',
    'projects' => 'ProjectController',
]);
Route::get('/project-assign/{project}/edit', 'ProjectController@editAssign')->name('project-assign.edit');
Route::patch('/project-assign/{project}', 'ProjectController@updateAssign')->name('project-assign.update');
Route::get('/project-assign/{projectId}/{employeeId}', 'ProjectController@destroyAssign')->name('project-assign.destroy');
Route::get('/tasks/{projectId}/employee', 'TaskController@getEmployeeInProject')->name('task.get-employee-in-project');
Route::get('/reports/{reportId}/{taskId}', 'ReportController@destroyTask')->name('report-task.destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/login/customer', 'Auth\LoginController@showCustomerLoginForm');
Route::post('/login/customer', 'Auth\LoginController@customerLogin');
//Route::view('/home', 'home')->middleware('auth');
//Route::view('/customer', 'customer');
