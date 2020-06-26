<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/home', 'HomeController@index');

Route::middleware('auth:sanctum')->get('/clients', 'ClientsController@index');
Route::middleware('auth:sanctum')->get('/show', 'ClientsController@show');
Route::middleware('auth:sanctum')->post('/clients/save', 'ClientsController@store');
Route::middleware('auth:sanctum')->post('/clients/update/{id}', 'ClientsController@update');
Route::middleware('auth:sanctum')->post('/clients/delete/{id}', 'ClientsController@destroy');
Route::middleware('auth:sanctum')->post('/clients/import', 'ClientsController@import');

Route::middleware('auth:sanctum')->get('/loans', 'LoansController@index');
Route::middleware('auth:sanctum')->get('/loans/names', 'LoansController@create');
Route::middleware('auth:sanctum')->get('/payments/export', 'LoansController@export_excel');
Route::middleware('auth:sanctum')->post('/loans', 'LoansController@store');
Route::middleware('auth:sanctum')->get('/loans/export', 'LoansController@export');

Route::middleware('auth:sanctum')->get('/payments', 'PaymentController@index');
Route::middleware('auth:sanctum')->get('/payments/list/{id}', 'PaymentController@list');
Route::middleware('auth:sanctum')->put('/payments/pay/{id}', 'PaymentController@update');

Route::middleware('auth:sanctum')->get('/user', 'UserController@find');
Route::middleware('auth:sanctum')->put('/user', 'UserController@update');