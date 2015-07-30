<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('client', 'ClientController@index');
Route::post('client', 'ClientController@store');
Route::put('client/{id}', 'ClientController@update');
Route::get('client/{id}', 'ClientController@show');
Route::delete('client/{id}', 'ClientController@destroy');

Route::get('project', 'ProjectController@index');
Route::post('project', 'ProjectController@store');
Route::put('project/{id}', 'ProjectController@update');
Route::get('project/{id}', 'ProjectController@show');
Route::delete('project/{id}', 'ProjectController@destroy');
Route::get('project/{project}/members', 'ProjectController@members');
Route::post('project/{project}/add-member', 'ProjectController@addMember');
Route::delete('project/{project}/remove-member', 'ProjectController@removeMember');
Route::get('project/{project}/is-member/{member}', 'ProjectController@isMember');

Route::get('project-note', 'ProjectNoteController@index');
Route::post('project-note', 'ProjectNoteController@store');
Route::put('project-note/{id}', 'ProjectNoteController@update');
Route::get('project-note/{id}', 'ProjectNoteController@show');
Route::delete('project-note/{id}', 'ProjectNoteController@destroy');

Route::get('project-task', 'ProjectTaskController@index');
Route::post('project-task', 'ProjectTaskController@store');
Route::put('project-task/{id}', 'ProjectTaskController@update');
Route::get('project-task/{id}', 'ProjectTaskController@show');
Route::delete('project-task/{id}', 'ProjectTaskController@destroy');