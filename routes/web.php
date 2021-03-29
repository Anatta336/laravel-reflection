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

Route::resource('employee', EmployeeController::class);
Route::resource('company', CompanyController::class);

// -- Company routes
// Route::get('/company/all', 'CompanyController@index')
//     ->name('company.index')
//     ->middleware('can:view,App\Company');

// Route::get('/company/view/{company}', 'CompanyController@show')
//     ->name('company.show')
//     ->middleware('can:view,company');

// Route::get('/company/edit/{company}', 'CompanyController@edit')
//     ->name('company.edit')
//     ->middleware('can:update,company');
// Route::patch('/company/edit/{company}', 'CompanyController@update')
//     ->name('company.update')
//     ->middleware('can:update,company');

// Route::delete('/company/delete/{company}', 'CompanyController@destroy')
//     ->name('company.destroy')
//     ->middleware('can:delete,company');

// Route::get('/company/add', 'CompanyController@create')
//     ->name('company.create')
//     ->middleware('can:create,App\Company');

// Route::post('/company/add', 'CompanyController@store')
//     ->name('company.store')
//     ->middleware('can:create,App\Company');

// -- EmployeesOfCompany routes
Route::get('/company/list-employees/{company}', 'EmployeesOfCompany@index')
    ->name('employeesOfCompany.list')
    ->middleware('can:view,App\Employee');

// add Auth routes, but set option to disable registering new users
Auth::routes(['register' => false]);

