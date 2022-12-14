<?php

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

Route::resource('posts', \App\Http\Controllers\PostController::class);
Route::resource('posts-crawl', \App\Http\Controllers\WPPostController::class);
Route::post('test', [\App\Http\Controllers\WPPostController::class, 'test']);
