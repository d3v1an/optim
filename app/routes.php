<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('main');
});

Route::get('/test', function()
{
	$command 	= L4shell::get();
	//$result 	= $command->setCommand('ls %s')->setArguments(array("-lah"))->execute();
	$result 	= $command->setCommand('which pngquant')->execute();

	return $result;
});

// Carga de imagenes al servidor
Route::post('ujpg', 'ImageController@uploadJPG');

// Carga de imagenes al servidor
Route::post('cjpg', 'ImageController@compressJPG');