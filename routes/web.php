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
    'project-human-resources' => 'ProjectHumanResourceController',
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
