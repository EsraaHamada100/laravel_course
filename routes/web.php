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
Route::get('create-post', [PostController::class, "showCreateForm"])->middleware('auth');
Route::post('create-post', [PostController::class, "storeNewPost"])->middleware('auth');
// here {post} means the id of post that will be passed 
Route::get('post/{post}', [PostController::class, "viewSinglePost"])->middleware('mustBeLoggedIn');
Route::delete('post/{post}', [PostController::class, "delete"]);

// profile related routes

/**
 * We write it like that because the database , automatically suppose that this field
 * is the id
 * ex : 'profile/{username:id}'
 * but actually we give the username field in database so we should tell him that 
 * and that is to benefit from the power of model
 */
Route::get('profile/{user:username}', [UserController::class, 'profile']);
