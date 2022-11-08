<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RenderMarkdown;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UploadImage;
use App\Http\Controllers\UserController;
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

Route::resource('categories', CategoryController::class);

Route::post('/topics/{topic}/like', [TopicController::class, 'like'])
    ->name('topics.like')
    ->can('like');
Route::resource('categories.topics', TopicController::class)
    ->shallow()
    ->only('show', 'create', 'store', 'edit', 'update', 'destroy');

Route::post('/comments/{comment}/like', [CommentController::class, 'like'])
    ->name('comments.like')
    ->can('like');
Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])
    ->name('comments.reply')
    ->can('create', \App\Models\Comment::class);
Route::resource('categories.topics.comments', CommentController::class)
    ->shallow()
    ->only('store', 'edit', 'update', 'destroy');

Route::get('/users/signup', [UserController::class, 'signup'])->name('users.signup');
Route::get('/users/signin', [UserController::class, 'signin'])->name('users.signin');
Route::post('/users/authenticate', [UserController::class, 'authenticate'])->name('users.authenticate');
Route::post('/users/signout', [UserController::class, 'signout'])->name('users.signout');
Route::get('/users/notifications', [UserController::class, 'notifications'])->name('users.notifications');
Route::post('/users/notifications/{notification}/read', [UserController::class, 'notificationRead'])->name('users.notifications.read');
Route::resource('users', UserController::class)
    ->only('store', 'edit', 'update', 'show');

Route::post('/upload/image', UploadImage::class)
    ->middleware('auth');
Route::post('/render/markdown', RenderMarkdown::class)
    ->middleware('auth');
