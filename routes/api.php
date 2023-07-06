<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Registration;
use App\Http\Controllers\Login;
use App\Http\Controllers\Profile;
use App\Http\Controllers\Changeprofilepage;
use App\Http\Controllers\Changepasspage;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/regs',[Registration::class,'registration']); //registration we need to update image link later
Route::post('/login',[Login::class,'login']); //login
Route::get('/profile/{usersl}/{tokenz}',[Profile::class,'profile']); //watching profile page api
Route::get('/changeprofilepage/{usersl}/{tokenz}',[Changeprofilepage::class,'changeprofilepage']); // page api for profile page data changing not submiting button
Route::get('/changepasspage/{usersl}/{tokenz}',[Changepasspage::class,'changepasspage']); //page api for password change page not submitting button