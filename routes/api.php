<?php

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

// http://127.0.0.1:8000/api/user with email/password
Route::post('admin', [UserController::class, 'adminStore']); //admin register
// http://127.0.0.1:8000/api/user with email/password
Route::post('user', [UserController::class, 'store']); //register
// http://127.0.0.1:8000/api/login with email/password
Route::post('login', [LoginController::class, 'login']); //login


//http://127.0.0.1:8000/api/user?api_token={api_token}
Route::middleware('auth:api')->get('user', [UserController::class, 'info']);  //check info
//http://127.0.0.1:8000/api/user?api_token={api_token}
Route::middleware('auth:api')->put('user', [UserController::class, 'update']); //edit account
//http://127.0.0.1:8000/api/user/{id}?api_token={api_token}
Route::middleware('auth:api')->delete('user/{users}', [UserController::class, 'destroy']); //delete
//http://127.0.0.1:8000/api/logout?api_token={api_token}
Route::middleware('auth:api')->get('logout', [LogoutController::class,'logout']); //logout