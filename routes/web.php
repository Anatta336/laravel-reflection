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
Route::get('/employee/{id}', 'EmployeeController@show')->name('employee.show');
Route::get('/employee/{id}/edit', 'EmployeeController@edit')->name('employee.edit');
Route::delete('/employee/{id}', 'EmployeeController@destroy')->name('employee.destroy');
Route::put('/employee/{id}', 'EmployeeController@create')->name('employee.create');

// use all the Auth routes, but disable registering new users
// Auth::routes();
Auth::routes(['register' => false]);

