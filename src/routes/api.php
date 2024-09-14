<?php

use App\Http\Controllers\llmController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// http://127.0.0.1:8000/api/adminSignUp with email/password
Route::post('adminSignUp', [UserController::class, 'adminStore']); //admin register
// http://127.0.0.1:8000/api/userSignUp with email/password
Route::post('userSignUp', [UserController::class, 'store']); //register
// http://127.0.0.1:8000/api/signIn with email/password
Route::post('signIn', [LoginController::class, 'login']); //login

//http://127.0.0.1:8000/api/user?api_token={api_token}
Route::middleware('auth:api')->get('user', [UserController::class, 'info']);  //check info
//http://127.0.0.1:8000/api/user?api_token={api_token}
Route::middleware('auth:api')->put('user', [UserController::class, 'update']); //edit account
//http://127.0.0.1:8000/api/user/{uid}?api_token={api_token}
Route::middleware('auth:api')->delete('user/{uid}', [UserController::class, 'destroy']); //delete
//http://127.0.0.1:8000/api/logout?api_token={api_token}
Route::middleware('auth:api')->get('logout', [LogoutController::class,'logout']); //logout

// http://127.0.0.1:8000/api/translate
//TODO:make gpt api authorized
Route::post('translate',[llmController::class, 'translate']);
