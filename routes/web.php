<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

// All listings
Route::get('/' ,[ListingController::class,'index']);
// Show create form (show form to add data)
Route::get('/listing/create',[ListingController::class,'create'])->middleware('auth');
// Store listing data (add new data)
Route::post('/listings',[ListingController::class,'store'])->middleware('auth');
// edit listing (show form with values)
Route::get('/listing/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');
// update listing (edit old data)
Route::put('/listing/{listing}',[ListingController::class,'update'])->middleware('auth');
// Manage Listing
Route::get('/listing/mange',[ListingController::class,'manage'])->middleware('auth');
// Delete listing (Delete old data)
Route::delete('/listing/{listing}',[ListingController::class,'destroy'])->middleware('auth');
// Singal list
Route::get('/listing/{listing}',[ListingController::class,'show']);




//////////////////////////////////////////////////////////////////////////
/////////////   User routing ////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////


//Show create Register form  (show form to add data) 
Route::get('/register',[UserController::class,'create'])->middleware('guest');
//Store User data 
Route::post('/users',[UserController::class,'store'])->middleware('guest'); 
//logout User 
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');
//Show login form
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');
// login user
Route::post('/login/authenticate',[UserController::class,'authenticate']);

