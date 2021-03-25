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
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

Route::get('/employee/all', 'EmployeeController@index')->name('employee.all');
Route::get('/employee/{employee}', 'EmployeeController@show')->name('employee.show');
Route::get('/employee/{employee}/edit', 'EmployeeController@edit')->name('employee.edit')->middleware('auth');
Route::delete('/employee/{employee}', 'EmployeeController@destroy')->name('employee.destroy')->middleware('auth');
Route::put('/employee/{employee}', 'EmployeeController@create')->name('employee.create')->middleware('auth');

// use all the Auth routes, but disable registering new users
// Auth::routes();
Auth::routes(['register' => false]);

