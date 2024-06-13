<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('users', 'App\Http\Controllers\UserController');
Route::resource('videos', 'App\Http\Controllers\VideoController');
Route::resource('articles', 'App\Http\Controllers\ArticleController');
Route::resource('comments', 'App\Http\Controllers\CommentController');