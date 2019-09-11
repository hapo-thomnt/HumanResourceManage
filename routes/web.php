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

Route::get('/login/employee', 'Auth\LoginController@showEmployeeLoginForm')->name('login.employee');
Route::get('/login/customer', 'Auth\LoginController@showCustomerLoginForm')->name('login.customer');

Route::post('/login/employee', 'Auth\LoginController@employeeLogin');
Route::post('/login/customer', 'Auth\LoginController@customerLogin');

Route::view('/home', 'home')->name('home');

Route::auth();
Route::group(['middleware' => 'auth'], function () {
    // All route your need authenticated
});
