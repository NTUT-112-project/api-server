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
Route::post('admin', [UserController::class, 'adminStore']); //admin註冊

// http://127.0.0.1:8000/api/user with email/password
Route::post('user', [UserController::class, 'store']); //註冊

// http://127.0.0.1:8000/api/login with email/password
Route::post('login', [LoginController::class, 'login']); //登入



//http://127.0.0.1:8000/api/user?api_token={api_token}
Route::middleware('auth:api')->get('user', [UserController::class, 'index']);  //查看

//http://127.0.0.1:8000/api/user?api_token={api_token}
Route::middleware('auth:api')->put('user', [UserController::class, 'update']); //編輯

//http://127.0.0.1:8000/api/user/{id}?api_token={api_token}
Route::middleware('auth:api')->delete('user/{users}', [UserController::class, 'destroy']); //刪除

//http://127.0.0.1:8000/api/logout?api_token={api_token}
Route::middleware('auth:api')->get('logout', [LogoutController::class,'logout']); //登出