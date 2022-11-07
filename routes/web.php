<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TopicController;
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

Route::resource('categories', CategoryController::class)
    ->only('index', 'show', 'create', 'store', 'edit', 'update', 'destroy');

Route::resource('categories.topics', TopicController::class)
    ->shallow()
    ->only('show', 'create', 'store', 'edit', 'update', 'destroy');

Route::resource('categories.topics.comments', CommentController::class)
    ->shallow()
    ->only('store', 'edit', 'update', 'destroy');
