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


Route::get('/', 'ControladorLogin@index');

Route::resource('Login','ControladorLogin');

Route::resource('Registrar','ControladorPaciente');

Route::resource('Principal','ControladorPrincipal');

Route::resource('Pacientes','ControladorListadoPaciente');

Route::resource('Medicos','ControladorListadoMedico');

Route::resource('Eventos','ControladorEventos');

Route::resource('Historial','ControladorHistorial');

Route::resource('Citas','ControladorCitas');

Route::resource('Agenda','ControladorAgenda');

Route::resource('Consulta','ControladorConsulta');

Route::resource('Error','ControladorError');



Route::get('api/persona/lista','API\PersonaController@index');
Route::get('api/persona/lista/{id}','API\PersonaController@show');
Route::post('api/persona/registro','API\PersonaController@store');
Route::post('api/persona/restartPassword','API\PersonaController@restartPassword');
Route::get('api/persona/login/{login}/{pass}','API\PersonaController@login');
Route::delete('api/persona/elimina/{id}','API\PersonaController@destroy');
Route::put('api/persona/actualiza/{id}','API\PersonaController@update');