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
    'assigns' => 'AssignController',
    'companies' => 'CompanyController',
    'customers' => 'CustomerController',
    'daily-assigns' => 'DailyAssignController',
    'daily-reports' => 'DailyReportController',
    'employees' => 'EmployeeController',
    'projects' => 'ProjectController',
]);
Route::get('/project-assign/{project}/edit', 'ProjectController@editAssign')->name('project-assign.edit');
Route::patch('/project-assign/{project}', 'ProjectController@updateAssign')->name('project-assign.update');
Route::get('/project-assign/{projectId}/{employeeId}', 'ProjectController@destroyAssign')->name('project-assign.destroy');
//Route::get('employees/','EmployeeController@search')->name('employees.search');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
