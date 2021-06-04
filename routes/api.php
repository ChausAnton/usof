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

Route::get('/test', function () {
    return ['message' => 'hello'];
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('user', 'App\Http\Controllers\UserController');
Route::resource('posts', 'App\Http\Controllers\PostsController');
Route::resource('category', 'App\Http\Controllers\CategoryController');
Route::resource('comment', 'App\Http\Controllers\CommentController');
Route::resource('like', 'App\Http\Controllers\LikeController');