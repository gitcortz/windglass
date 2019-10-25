<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('customers', 'CustomerController@index');
    Route::get('customers/{customer}', 'CustomerController@show');
    Route::post('customers', 'CustomerController@store');
    Route::put('customers/{customer}', 'CustomerController@update');
    Route::delete('customers/{customer}', 'CustomerController@delete');
});


Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

/*
Route::get('customers', 'CustomerController@index');
    Route::get('customers/{customer}', 'CustomerController@show');
    Route::post('customers', 'CustomerController@store');
    Route::put('customers/{customer}', 'CustomerController@update');
    Route::delete('customers/{customer}', 'CustomerController@delete');
*/
Route::get('users', 'UserController@index');
Route::get('users/{user}', 'UserController@show');
Route::post('users', 'UserController@store');
Route::put('users/{user}', 'UserController@update');
Route::delete('users/{user}', 'UserController@delete');

Route::get('suppliers', 'SupplierController@index');
Route::get('suppliers/{supplier}', 'SupplierController@show');
Route::post('suppliers', 'SupplierController@store');
Route::put('suppliers/{supplier}', 'SupplierController@update');
Route::delete('suppliers/{supplier}', 'SupplierController@delete');

Route::get('stores', 'StoreController@index');
Route::get('stores/{store}', 'StoreController@show');
Route::post('stores', 'StoreController@store');
Route::put('stores/{store}', 'StoreController@update');
Route::delete('stores/{store}', 'StoreController@delete');

Route::get('products', 'ProductController@index');
Route::get('products/{product}', 'ProductController@show');
Route::post('products', 'ProductController@store');
Route::put('products/{product}', 'ProductController@update');
Route::delete('products/{product}', 'ProductController@delete');

Route::get('employees', 'EmployeeController@index');
Route::get('employees/payroll/generate', 'EmployeeController@payroll');
Route::get('employees/{employee}', 'EmployeeController@show');
Route::get('employees/{employee_id}/timesheet/{from}/{to}', 'EmployeeController@timesheet');
Route::post('employees', 'EmployeeController@store');
Route::put('employees/{employee}', 'EmployeeController@update');
Route::delete('employees/{employee}', 'EmployeeController@delete');
Route::post('employees/{employee_id}/loan', 'EmployeeController@add_loan');

Route::get('orders', 'OrderController@index');
Route::get('orders/{order}', 'OrderController@show');
Route::post('orders', 'OrderController@store');
Route::put('orders/{order}', 'OrderController@update');
Route::delete('orders/{order}', 'OrderController@delete');

Route::get('ordersItems', 'OrderItemController@index');
Route::get('ordersItems/{ordersItem}', 'OrderItemController@show');
Route::post('ordersItems', 'OrderItemController@store');
Route::put('ordersItems/{ordersItem}', 'OrderItemController@update');
Route::delete('ordersItems/{ordersItem}', 'OrderItemController@delete');

Route::get('timesheets', 'TimesheetController@index');
Route::get('timesheets/{timesheet}', 'TimesheetController@show');
Route::post('timesheets', 'TimesheetController@store');
Route::put('timesheets/{timesheet}', 'TimesheetController@update');
Route::delete('timesheets/{timesheet}', 'TimesheetController@delete');

Route::get('payroll/timesheets/{from}/{to}', 'PayrollController@getTimesheetInformation');

Route::get('pos', 'POSController@index');
Route::get('pos/{posSession}}', 'POSController@show');
Route::post('pos/open', 'POSController@open');
Route::put('pos/{posSession}', 'POSController@close');
Route::post('pos/{posSession}/order', 'POSController@create_order');