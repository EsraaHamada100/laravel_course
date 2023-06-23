<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Middleware guest is a given middleware that allows only guest to enter the route
 * Middleware auth is a given middleware that allows only authenticated users to enter the route
 * 
 */

// User related routes

// we named it login because auth middleware will redirect to something named
// login and we wanna it to redirect him to '/' so we name it login 
Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');
Route::post('/register', [UserController::class, "register"])->middleware('guest');
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/logout', [UserController::class, "logout"])->middleware('auth');

// Blog post routes
Route::get('create-post', [PostController::class, "showCreateForm"])->middleware('guest');
Route::post('create-post', [PostController::class, "storeNewPost"])->middleware('auth');
// here {post} means the id of post that will be passed 
Route::get('post/{post}', [PostController::class, "viewSinglePost"])->middleware('mustBeLoggedIn');



