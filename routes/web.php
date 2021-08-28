<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\RatingController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [PostController::class, 'index']);
Route::get('/posts/list', [PostController::class, 'list'])->name('posts.list');
Route::get('/posts/{id}/deleteImage', [PostController::class, 'deleteImage'])->name('posts.deleteImage');

Route::post('/rating/{id}', [RatingController::class, 'rate'])->name('rate.store');

Auth::routes();

Route::resource('posts', PostController::class);

