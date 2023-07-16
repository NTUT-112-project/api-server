<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
Route::post('user', [UserController::class, 'store']); //註冊
Route::post('login', [LoginController::class, 'login']); //登入


Route::middleware('auth:api')->get('user', [UserController::class, 'index']);  //查看
Route::middleware('auth:api')->put('user', [UserController::class, 'update']); //編輯
Route::middleware('auth:api')->delete('user/{members}', [UserController::class, 'destroy']); //刪除
Route::middleware('auth:api')->get('logout', [LogoutController::class,'logout']); //登出