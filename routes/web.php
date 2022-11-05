<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', \App\Http\Controllers\CategoryController::class)
    ->only('index', 'show', 'create', 'store', 'edit', 'update', 'destroy');

Route::resource('categories.topics', \App\Http\Controllers\TopicController::class)
    ->shallow()
    ->only('show', 'create', 'store', 'edit', 'update', 'destroy');
