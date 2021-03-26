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
Route::get('/home', 'HomeController@index')
    ->name('home');
Route::get('/', 'HomeController@index')
    ->name('home');

// -- Employee routes
// list all
Route::get('/employee/all', 'EmployeeController@index')
    ->name('employee.all');

// show individual
Route::get('/employee/view/{employee}', 'EmployeeController@show')
    ->name('employee.show');

// edit existing
Route::get('/employee/edit/{employee}', 'EmployeeController@edit')
    ->name('employee.edit')->middleware('auth');
Route::put('/employee/edit/{employee}', 'EmployeeController@update')
    ->name('employee.update')->middleware('auth');

// delete existing
Route::delete('/employee/delete/{employee}', 'EmployeeController@destroy')
    ->name('employee.destroy')->middleware('auth');

// add new
Route::get('/employee/add', 'EmployeeController@create')
    ->name('employee.create')->middleware('auth');
Route::post('/employee/add', 'EmployeeController@store')
    ->name('employee.store')->middleware('auth');

// -- Company routes
Route::get('/company/all', 'CompanyController@index')
    ->name('company.all');

Route::get('/company/view/{company}', 'CompanyController@show')
    ->name('company.show');

Route::get('/company/edit/{company}', 'CompanyController@edit')
    ->name('company.edit')->middleware('auth');
Route::patch('/company/edit/{company}', 'CompanyController@update')
    ->name('company.update')->middleware('auth');

Route::delete('/company/delete/{company}', 'CompanyController@destroy')
    ->name('company.destroy')->middleware('auth');

Route::get('/company/add', 'CompanyController@create')
    ->name('company.create')->middleware('auth');
Route::put('/company/add', 'CompanyController@store')
    ->name('company.store')->middleware('auth');

// add Auth routes, but set option to disable registering new users
Auth::routes(['register' => false]);

