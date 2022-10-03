<?php

// use index;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;

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
// All listing
Route::get('/',[ListingController::class,'index']);
// Show create post
Route::get('/listings/create',[ListingController::class,'create'])->middleware('auth');
// Store post
Route::post('/listings',[ListingController::class,'store'])->middleware('auth');
// Edit
Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');
// update
Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');
// delete
Route::delete('/listings/{listing}',[ListingController::class,'delete'])->middleware('auth');
// Manage Settings
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');



// Route::put('/listings/{listing}', [ListingController::class, 'update'])
// Route::post('/listings/{lisiting}/edit',[ListingController::class,'edit']);

// Single listing (the reason create ddint load up is beacuse it was looking {id} as create so we push it down)
Route::get('/listings/{id}', [ListingController::class,'show']);
// Create (get req )Register User
Route::get('/register',[UserController::class,'create']);
// Create (psot req )Register User
Route::post('/users',[UserController::class,'store']);
// Logout
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');
// Login view
Route::get('/login',[UserController::class,'login'])->name('login');
// Login submit
Route::post('/users/authenticate',[UserController::class,'authenticate']);
