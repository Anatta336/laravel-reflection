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

Route::get('/', 'HomeController@index')
    ->name('home');

// -- Employee routes
// list all
Route::get('/employee/all', 'EmployeeController@index')
    ->name('employee.all')
    ->middleware('can:view,App\Employee');

// show individual
Route::get('/employee/view/{employee}', 'EmployeeController@show')
    ->name('employee.show')
    ->middleware('can:view,employee');

// edit existing
Route::get('/employee/edit/{employee}', 'EmployeeController@edit')
    ->name('employee.edit')
    ->middleware('can:update,employee');
Route::put('/employee/edit/{employee}', 'EmployeeController@update')
    ->name('employee.update')
    ->middleware('can:update,employee');

// delete existing
Route::delete('/employee/delete/{employee}', 'EmployeeController@destroy')
    ->name('employee.destroy')
    ->middleware('can:delete,employee');

// add new
Route::get('/employee/add', 'EmployeeController@create')
    ->name('employee.create')
    ->middleware('can:create,employee');
Route::post('/employee/add', 'EmployeeController@store')
    ->name('employee.store')
    ->middleware('can:create,employee');

// -- Company routes
Route::get('/company/all', 'CompanyController@index')
    ->name('company.all')
    ->middleware('can:view,App\Company');

Route::get('/company/view/{company}', 'CompanyController@show')
    ->name('company.show')
    ->middleware('can:view,company');

Route::get('/company/edit/{company}', 'CompanyController@edit')
    ->name('company.edit')
    ->middleware('can:update,company');
Route::patch('/company/edit/{company}', 'CompanyController@update')
    ->name('company.update')
    ->middleware('can:update,company');

Route::delete('/company/delete/{company}', 'CompanyController@destroy')
    ->name('company.destroy')
    ->middleware('can:delete,company');

Route::get('/company/add', 'CompanyController@create')
    ->name('company.create')
    ->middleware('can:create,App\Company');

Route::post('/company/add', 'CompanyController@store')
    ->name('company.store')
    ->middleware('can:create,App\Company');

// add Auth routes, but set option to disable registering new users
Auth::routes(['register' => false]);

