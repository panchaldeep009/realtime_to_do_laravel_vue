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

Route::get('/tasks', 'ToDoController@getTasks');
Route::put('/task', 'ToDoController@updateTask');
Route::post('/task', 'ToDoController@postTask');
Route::delete('/task', 'ToDoController@deleteTask');

Route::get('/users', 'ToDoUserController@getUsers');
Route::get('/user', 'ToDoUserController@getUser');
Route::post('/user', 'ToDoUserController@createUser');
Route::delete('/user', 'ToDoUserController@deleteUser');
Route::get('/keepOnline', 'ToDoUserController@keepOnline');