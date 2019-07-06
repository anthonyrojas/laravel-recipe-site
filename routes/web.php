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

Route::get('/', function () {
    return view('index');
});

Auth::routes();
Route::get('/recipes', 'RecipeController@get_recipes');
Route::get('/account/recipes', 'RecipeController@get_my_recipes');
Route::get('/account', 'HomeController@index')->name('account');
Route::get('/recipe/create', 'RecipeController@create_recipe');
Route::post('/recipe/create', 'RecipeController@create');
Route::post('/recipe/{id}/update', 'RecipeController@update');
Route::get('/recipe/{id}/edit', 'RecipeController@edit_recipe');
Route::get('/recipe/{id}', 'RecipeController@get_recipe');
Route::delete('/recipe/{id}', 'RecipeController@delete');