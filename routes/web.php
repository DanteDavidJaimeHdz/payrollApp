<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

//returns welcome view
Route::get('/', function () {
    return view('welcome');
});

// API


//movement routes
Route::group(['prefix'=>'movements'],function(){
    Route::post('movement/createMovement','App\Http\Controllers\MovementController@createOrUpdateMovement');
    Route::get('movement/getMovements','App\Http\Controllers\MovementController@getList');
    Route::get('movement/getListForSelect','App\Http\Controllers\MovementController@getMovementForSelect');
    Route::post('movement/updateMovement','App\Http\Controllers\MovementController@update');
    Route::get('movement/getReport','App\Http\Controllers\MovementController@getReport');
    Route::post('movement/searchData','App\Http\Controllers\MovementController@searchData');
});

//employees routes
Route::group(['prefix'=>'employees'],function(){
    Route::post('employee/createEmployee','App\Http\Controllers\EmployeeController@createEmployee');
    Route::get('employee/getEmployees','App\Http\Controllers\EmployeeController@getList');
    Route::post('employee/getListForSelect','App\Http\Controllers\EmployeeController@getEmployeeForSelect');
    Route::post('employee/updateEmployee','App\Http\Controllers\EmployeeController@update');
    Route::get('employee/getReport','App\Http\Controllers\EmployeeController@getReport');
});


//roles routes
Route::group(['prefix'=>'roles'],function(){
    Route::post('rol/createRole','App\Http\Controllers\RoleController@createRole');
    Route::get('rol/getRoles','App\Http\Controllers\RoleController@getList');
    Route::get('role/getRoleForSelect','App\Http\Controllers\RoleController@getRoleForSelect');
    Route::post('rol/rol/searchData','App\Http\Controllers\RoleController@searchData');
    Route::post('rol/updateEmployee','App\Http\Controllers\RoleController@update');
    Route::get('rol/getReport','App\Http\Controllers\RoleController@getReport');
});

//config routes
Route::group(['prefix'=>'configs'],function(){
    Route::post('config/saveConfig','App\Http\Controllers\ConfigController@saveConfig');
    Route::get('config/getConfig','App\Http\Controllers\ConfigController@getConfig');
});

//dashboard routes
Route::group(['prefix'=>'dashboards'],function(){
    Route::post('dashboard/getData','App\Http\Controllers\DashboardController@getData');
    Route::post('dashboard/getEmployeeData','App\Http\Controllers\DashboardController@getEmployeeData');
    
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
