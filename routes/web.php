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

Route::get('/company/{company}/employees/', 'EmployeesOfCompany@index')
    ->name('employeesOfCompany.index')
    ->middleware('can:view,App\Employee');

// add Auth routes, but set option to disable registering new users
Auth::routes(['register' => false]);

