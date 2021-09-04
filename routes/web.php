<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::middleware(['auth'])->group(function () {
    //Categorias
    Route::resource('categories', 'CategoryController');
    //Recetas
    Route::get('/recipes', 'RecipeController@index')->name('recipes.index');
    Route::get('/recipes/create', 'RecipeController@create')->name('recipes.create');
    Route::post('/recipes', 'RecipeController@store')->name('recipes.store');
    Route::get('/recipes/{recipe}/edit', 'RecipeController@edit')->name('recipes.edit');
    Route::put('/recipes/{recipe}', 'RecipeController@update')->name('recipes.update');
    Route::delete('/recipes/{recipe}', 'RecipeController@destroy')->name('recipes.destroy');
    //Usuarios
    Route::resource('users', 'UserController');
});

//Dashboard
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

//Vista principal
Route::get('/', 'PageController@index');
//Resultados de búsqueda
Route::get('/search', 'PageController@search')->name('page.search');
//Vista de recetas por categoría
Route::get('/{category}', 'PageController@showCategory')->name('page.showCategory');
//Vista de recetas likeadas
Route::get('/{user}/favorites', 'PageController@showFavorites')->name('page.showFavorites');
//Vista individual
Route::get('/recipes/{recipe}', 'RecipeController@show')->name('recipes.show');

